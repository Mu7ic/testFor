<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sentance".
 *
 * @property integer $id
 * @property string $text
 * @property integer $datecreate
 * @property integer $lastupdate
 * @property integer $id_user
 * @property integer $enable
 * @property integer $status
 *
 * @property Users $idUser
 * @property Texts[] $texts
 */
class Sentance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sentance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'datecreate', 'lastupdate', 'id_user', 'enable', 'status'], 'required'],
            [['text'], 'string'],
            [['text'],'checkPattern'],
            //['text', 'match', 'pattern' => '/^([а-яё\s]+|[a-z\s]+)$/iu','message'=>'Нельзя совмещать латинские и русские буквы'],

            //[['datecreate', 'lastupdate', 'id_user', 'enable', 'status'], 'integer'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'datecreate' => 'Datecreate',
            'lastupdate' => 'Lastupdate',
            'id_user' => 'Id User',
            'enable' => 'Видимость',
            'status' => 'Status',
        ];
    }

    public function checkPattern(){
      $this->checkForSymbols();
      $this->checkForDefis();
      $this->checkLatinoKirillica();
      $this->checkCountWord();
      $this->checkCountWordSymbols();
      $this->checkZnaki();

    }

    public function checkForSymbols(){
        //if(!preg_match("/^[^0-9A-Za-zА-Яа-яЁё?]\!\.\-\:\;+$/u",$this->text))
        //    $this->addError("text", 'Допустимы только буквы, цифры и спец символы !.-:;');
        $needle="--";
        if (strpos($this->text, $needle) !== false) {
            $this->addError("text", 'В тексте найдены 2 дефиса');
        }
    }

    public function checkZnaki(){
        $tochka=".";
        $znak="!";
        $vopros="?";
        $pos_tochka=strripos($this->text, $tochka);
        $pos_znak=strripos($this->text, $znak);
        $pos_vopros=strripos($this->text, $vopros);
        if(!empty($pos_tochka) ? $pos_tochka!=(strlen($this->text)-1) : '')
            $this->addError("text", 'Точка находиться не в конце предложения!');

        if(!empty($pos_znak) ? $pos_znak!=(strlen($this->text)-1) : '')
            $this->addError("text", 'Восклицательных находиться не в конце предложения!');

        if(!empty($pos_vopros) ? $pos_vopros!=(strlen($this->text)-1) : '')
            $this->addError("text", 'Вопросительный знак находиться не в конце предложения!');


    }

    public function checkCountWordSymbols(){
        $defis  = explode("-" , $this->text );
        $tochka  = explode("." , $this->text );
        $vopros  = explode("?" , $this->text );
        $hitob  = explode("!" , $this->text );
        if(count($defis) > 3 or count($tochka)>4 or count($vopros)>4 or count($hitob)>4)
            $this->addError("text", 'В предложении более трех спец символов');
    }

    public function checkForDefis(){
        $handle="-";
        $firstPos=$this->text{0};
        $lastPos=substr($this->text,-1);
        if($firstPos==$handle){
            $this->addError("text", 'Нельзя ставить дефис в начале предложения');
           return $bool=false;
        } elseif($lastPos==$handle){
            $this->addError("text", 'Нельзя ставить дефис в конце предложения');
           return $bool=false;
        }else return $bool=true;
    }

    public function checkCountWord(){
        $c   = str_word_count($this->text,1, "АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя");
        if(count($c)<3)
            $this->addError("text", 'Предложение должен состоит не менее чем из трёх слов');
    }

    public function checkLatinoKirillica(){
        $check1 = preg_match("/[0-9a-zA-Z!-?:;]+/",$this->text);
        $check2 = preg_match("/[0-9а-яА-ЯёЁ!-?:;]+/",$this->text);
        if( ($check1 && !$check2) || (!$check1 && $check2) )
            $this->addError("text", 'Нельзя совмещать латинские и русские буквы');

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTexts()
    {
        return $this->hasMany(Texts::className(), ['id_sentence' => 'id']);
    }
}
