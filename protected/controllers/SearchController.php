<?php
class SearchController extends Controller {

	const RESULTS_LIMIT = 100;

    public function init() {
        Yii::app()->errorHandler->errorAction = '/search/error';
    }

    public function actionError() {
        $error = Yii::app()->errorHandler->error;
        $this->renderJSON(array(
            'success' => false,
            'error' => array(
                'code' => 'INTERNAL_ERROR',
                'type' => $error['type'],
                'httpCode' => $error['code'],
                'message' => $error['message'],
                'type' => $error['type'],
                'file' => $error['file'],
                'line' => $error['line']
            )
        ));
    }

    public function actionIndex() {
        $ret = array(
            'success' => false,
            'limited' => false
        );

        $table = $_GET['t'];
        $criteria = $_GET['c'];

        if (!is_string($table))
            $ret['error'] = array('code' => 'MISSING_ARGUMENTS', 'argument' => 't');

        else if (!is_array($criteria))
            $ret['error'] = array('code' => 'MISSING_ARGUMENTS', 'argument' => 'c');

        else {
            $model = $this->getModel($table);

            if ($model == null) {
                $ret['error'] = array('code' => 'INVALID_TABLE', 'table' => $table);
            } else {
                $command = Yii::app()->db->createCommand()
                    ->from('slots')
                    ->limit(self::RESULTS_LIMIT + 1);

                try {
                    $count = $this->processCriteriaList($command, $model, $criteria);
                    if ($count == 0) {
                        $ret['error'] = array('code' => 'NO_CRITERIA');
                    } else {
                        if (defined("YII_DEBUG") && YII_DEBUG)
                            $ret['sql'] = $command->text;

                        $ret['records'] = $command->queryAll();

                        if (count($ret['records']) > self::RESULTS_LIMIT) {
                            array_pop($ret['records']);
                            $ret['limited'] = true;
                        }

                        $ret['success'] = true;
                    }
                } catch (CriteriaException $e) {
                    $ret['error'] = array(
                        'code' => 'INVALID_CRITERIA',
                        'message' => $e->getMessage()
                    );
                }
            }
        }

        $this->renderJSON($ret);
    }

	private function getModel($name) {
		if (!is_string($name))
			return null;

		switch ($name) {
			case 'slots': return Slots::model();
			default: return null;
		}
	}

	private function processCriteriaList($command, $model, $list) {
		$count = 0;
		foreach ($list as $key => $value) {
			if (!is_string($value))
				throw new CriteriaException(CriteriaException::INVALID_DATATYPE, $value);

			$this->addCriteria($command, $model, $value, $count);
			$count++;
		}
		return $count;
	}

	private function addCriteria($command, $model, $criteria, $index) {
		$split = explode('-', $criteria, 3);

		if (count($split) == 2) {
			$field = $split[0];
			$operator = '=';
			$value = $split[1];
		}
		elseif (count($split) == 3) {
			$field = $split[0];
			$operator = $split[1];
			$value = $split[2];
		}
		else {
			throw new CriteriaException(CriteriaException::INVALID_FORMAT, $criteria);
		}

		if ($model instanceof IAttributeTranslator)
			$field = $model->getTranslatedAttribute($field);

		if (!$model->hasAttribute($field))
			throw new CriteriaException(CriteriaException::INVALID_FIELD, $criteria, $operator, $field);

		switch ($operator) {
			case '=':
			case 'eq':
				$operator = '=';
				break;
			case 'lt':
				$operator = '<';
				break;
			case 'gt':
				$operator = '>';
				break;
			case 'lte':
				$operator = '<=';
				break;
			case 'gte':
				$operator = '>=';
				break;
			default:
				throw new CriteriaException(CriteriaException::INVALID_OPERATOR, $criteria, $operator);
		}

		// TODO: Validate value.

		$command->andWhere($field . ' ' . $operator . ' :c' . $index, array(':c' . $index => $value));
	}
}