<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_s_bank_agent_code".
 *
 * @property int $id
 * @property string $bank_code
 * @property string $bank_name
 */
class TSBankAgentCode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_s_bank_agent_code';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bank_code', 'bank_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('norm', 'ID'),
            'bank_code' => Yii::t('norm', 'Bank Code'),
            'bank_name' => Yii::t('norm', 'Bank Name'),
        ];
    }
}
