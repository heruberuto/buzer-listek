<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\dao\User;
use yii\db\Expression;

/**
 * UserSearch represents the model behind the search form about `app\models\dao\User`.
 */
class UserSearch extends User
{
    const HABIT_LIST_COUNT_QUERY = "(SELECT count(*) FROM `habit_list` WHERE `user_id` = `user`.`id`)";
    public $habitListsCount;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'has_admin_rights', 'habitListsCount'], 'integer'],
            [['email', 'password', 'auth_key', 'created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'has_admin_rights' => $this->has_admin_rights,
            self::HABIT_LIST_COUNT_QUERY => $this->habitListsCount
        ]);
        $dataProvider->sort->attributes['habitListsCount'] = ['asc' => [self::HABIT_LIST_COUNT_QUERY => SORT_ASC], 'desc' => [self::HABIT_LIST_COUNT_QUERY => SORT_DESC]];
        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', new Expression('DATE_FORMAT(created_at, "%d.%m.%Y %H:%i")'), $this->created_at])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key]);

        return $dataProvider;
    }
}
