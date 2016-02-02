<?php
namespace app\filters;

use app\models\Barang;

class BarangRule extends \yii\filters\AccessRule
{
	public $allow = true;  // Allow access if this rule matches
	public $roles = ['@']; // Ensure user is logged in.

	public function allows($action, $user, $request)
	{
		$parentRes = parent::allows($action, $user, $request);
		// $parentRes can be `null`, `false` or `true`.
		// True means the parent rule matched and allows access.
		if ($parentRes !== true) {
			return $parentRes;
		}		
		
		return (($this->getBarangCreatorId($request) == $user->id));
		//return false;
	}

	private function getBarangCreatorId($request)
	{
		// Fill in code to receive the right project.
		// assuming the project id is given à la `project/update?id=1`
		
		$projectId = $request->get('id');
		$brg = Barang::findOne($projectId);
		return isset($brg) ? $brg->created_by : null;
	}
}