<?php
/**
 * Created by PhpStorm.
 * User: LHP
 * Date: 2020/6/3
 * Time: 11:57
 */
namespace qingrui\models\searchs;
use qingrui\models\ResumeProject;
use qingrui\models\ResumeSchool;
use qingrui\models\ResumeWork;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use qingrui\models\Resume as ResumeModel;
class Resume extends ResumeModel
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','post','sex','username','telphone','current_city','current_company','current_branch','current_post','education'], 'safe'],
        ];
    }
    /**
     * Searching Resume
     * @param  array $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params,$where=[])
    {
        $query = ResumeModel::find()
            ->from(ResumeModel::tableName() . ' r')
            ->leftJoin(['u'=>'t_admin'],'u.id=r.admin_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        if($where){
            $query->andFilterWhere($where);
        }
        $sort = $dataProvider->getSort();
        $sort->attributes['r.updated_at'] = [
            'asc' => ['r.updated_at' => SORT_ASC],
            'desc' => ['r.updated_at' => SORT_DESC],
            'label' => 'updated_at',
        ];
        $sort->defaultOrder = ['r.updated_at' => SORT_DESC];
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'u.username', $this->username]);
        $query->andFilterWhere(['like', 'r.name', $this->name]);
        $query->andFilterWhere(['like', 'r.telphone', $this->telphone]);
        $query->andFilterWhere(['like', 'r.sex', $this->sex]);
        $query->andFilterWhere(['like', 'r.current_city', $this->current_city]);
        $query->andFilterWhere(['like', 'r.current_company', $this->current_company]);
        $query->andFilterWhere(['like', 'r.current_branch', $this->current_branch]);
        $query->andFilterWhere(['like', 'r.current_post', $this->current_post]);
        return $dataProvider;
    }
    /**
     * 简历教育经历
     * @param  array $params
     * @return \yii\data\ActiveDataProvider
     */
    public function Resumedetail($where=[])
    {
        $school=ResumeSchool::findAll(['resume_id'=>$where['id']]);
        $dataProvider = new ActiveDataProvider([
            'query' => $school,
        ]);
        return $dataProvider;
    }

}