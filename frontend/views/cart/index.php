<?php

use common\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="card">
    <div class="card-header">
        <h3>Your Cart Items</h3>
    </div>
    <div class="card-body p-0">
        <?php if(!empty($items)): ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) : ?>
                    <tr>
                        <td> <?php echo $item['name'] ?> </td>
                        <td>
                            <img src="<?php echo Product::formatImageUrl($item['image'] ) ?>" alt="" style="width: 50px;">
                        </td>
                        <td><?php echo $item['price'] ?></td>
                        <td><?php echo $item['quantity'] ?></td>
                        <td><?php echo $item['total_price'] ?></td>
                        <td>
                            <?php echo Html::a('Delete', ['/cart/delete', 'id' => $item['id']], [
                                'class' => 'btn btn-outline-danger btn-sm',
                                'data-method' => 'post',
                                'data-confirm' => 'Are you sure to delete this product?'
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <div class="card-body text-right">

            <a href="<?php echo Url::to(['/cart/checkout']) ?>" class="btn btn-primary">Checkout</a>
        </div>
        
        <?php else: ?>
        
            <p class="text-muted text-center p-5">There are no items in the cart</p>

        <?php endif; ?>
    </div>
</div>