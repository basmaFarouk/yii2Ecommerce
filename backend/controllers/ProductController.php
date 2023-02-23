<?php

namespace backend\controllers;

use Yii;
use Exception;
use yii\db\Query;
use yii\web\Controller;
use common\models\Model;
use yii\web\UploadedFile;
use common\models\Product;
use yii\helpers\VarDumper;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\ProductTypes;
use yii\web\NotFoundHttpException;
use backend\models\search\ProductSearch;

use function PHPUnit\Framework\isEmpty;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        Yii::warning($this->request->queryParams);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();
        $modelsProductTypes = [new ProductTypes()];
        //  $model->imageFile= UploadedFile::getInstance($model,'imageFile');
        $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        // var_dump($model->imageFile );
        // exit;


        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // var_dump(Yii::$app->request->post('ProductTypes')[0]['size']);
                // exit;
                if(isset(Yii::$app->request->post('ProductTypes')[0])){
                    $model->save();
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{

                $modelsProductTypes = Model::createMultiple(ProductTypes::class);
    
                // validate all models
                $valid = $model->validate();
                $valid = Model::validateMultiple($modelsProductTypes) && $valid;
                
                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            foreach ($modelsProductTypes as $modelsProductType) {
                                $modelsProductType->product_id = $model->id;
                                if (! ($flag = $modelsProductType->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            if ($model->uploadImage()) {
                                $model->save();
                            };
                            $transaction->commit();
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }

            }

              //  return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'modelsProductTypes'=>(empty($modelsProductTypes)) ? [new ProductTypes] : $modelsProductTypes,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionProductList($q = null, $id = null) {
    //    $data= ArrayHelper::map(Product::find()->all(), 'id', 'name');
    //    return json_encode($data);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, name')
                ->from('products')
                ->where(['like', 'name', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Product::find($id)->name];
        }
        return $out;
    }
}
