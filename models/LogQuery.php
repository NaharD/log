<?php

namespace nahard\log\models;

/**
 * This is the ActiveQuery class for [[LogGii]].
 *
 * @see LogGii
 */
class LogQuery extends \yii\db\ActiveQuery
{
	public function statusUnread()
	{
		return $this->andWhere(['status' => Log::STATUS_UNREAD]);
	}

	public function statusRead()
	{
		return $this->andWhere(['status' => Log::STATUS_READ]);
	}

	/*public function active()
	{
		return $this->andWhere('[[status]]=1');
	}*/

    /**
     * @inheritdoc
     * @return LogGii[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return LogGii|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
