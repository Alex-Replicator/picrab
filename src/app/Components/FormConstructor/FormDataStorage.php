<?php
namespace Picrab\Components\FormConstructor;

use Picrab\Components\Database\Database;

class FormDataStorage
{
    private FormModel $model;

    public function __construct(Database $db)
    {
        $this->model = new FormModel($db);
    }

    public function getFormData(int $pageId, int $pageTypeId): array
    {
        $groups = $this->model->getGroupsForPage($pageId, $pageTypeId);
        $values = $this->model->getValuesForPage($pageId);
        $result = [];
        foreach ($groups as $g) {
            $fields = $this->model->getFieldsForGroup($g['id']);
            $fArr = [];
            foreach ($fields as $f) {
                $fid = $f['id'];
                $fArr[] = [
                    'id' => $fid,
                    'name' => $f['name'],
                    'label' => $f['label'],
                    'type' => $f['type'],
                    'settings' => json_decode($f['settings'], true),
                    'value' => $values[$fid] ?? ''
                ];
            }
            $result[] = [
                'group_id' => $g['id'],
                'title' => $g['title'],
                'fields' => $fArr
            ];
        }
        return $result;
    }

    public function saveFormData(int $pageId, array $data): void
    {
        $this->model->saveValues($pageId, $data);
    }
}