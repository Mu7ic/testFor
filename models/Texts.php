<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "texts".
 *
 * @property integer $id
 * @property integer $id_random
 * @property integer $id_sentence
 * @property string $text
 * @property integer $datecreate
 * @property integer $lastupdate
 * @property integer $enable
 * @property integer $status
 *
 * @property Sentance $idSentence
 */
class Texts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'texts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_random', 'id_sentence', 'text', 'datecreate', 'lastupdate', 'enable', 'status'], 'required'],
            [['id_random', 'id_sentence', 'datecreate', 'lastupdate', 'enable', 'status'], 'integer'],
            [['text'], 'string'],
            [['id_sentence'], 'exist', 'skipOnError' => true, 'targetClass' => Sentance::className(), 'targetAttribute' => ['id_sentence' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_random' => 'Id Random',
            'id_sentence' => 'Id Sentence',
            'text' => 'Text',
            'datecreate' => 'Datecreate',
            'lastupdate' => 'Lastupdate',
            'enable' => 'Enable',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSentence()
    {
        return $this->hasOne(Sentance::className(), ['id' => 'id_sentence']);
    }
}
