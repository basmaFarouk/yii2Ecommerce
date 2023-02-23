<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_types}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%products}}`
 */
class m230223_085918_create_product_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_types}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(11)->notNull(),
            'size' => $this->string(255)->notNull(),
            'weight' => $this->string(255)->notNull(),
            'color' => $this->string(255)->notNull(),
        ]);

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-product_types-product_id}}',
            '{{%product_types}}',
            'product_id'
        );

        // add foreign key for table `{{%products}}`
        $this->addForeignKey(
            '{{%fk-product_types-product_id}}',
            '{{%product_types}}',
            'product_id',
            '{{%products}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%products}}`
        $this->dropForeignKey(
            '{{%fk-product_types-product_id}}',
            '{{%product_types}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-product_types-product_id}}',
            '{{%product_types}}'
        );

        $this->dropTable('{{%product_types}}');
    }
}
