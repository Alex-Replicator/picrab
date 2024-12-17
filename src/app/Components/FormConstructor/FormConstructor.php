<?php
namespace Picrab\Components\FormConstructor;

use Picrab\Components\Database\Database;

class FormConstructor
{
    private FormDataStorage $storage;

    public function __construct(Database $db)
    {
        $this->storage = new FormDataStorage($db);
    }

    public function getFieldsForPage(int $pageId, int $pageTypeId): array
    {
        return $this->storage->getFormData($pageId, $pageTypeId);
    }

    public function saveFields(int $pageId, array $data): void
    {
        $formatted = [];
        foreach ($data as $fieldId => $value) {
            $formatted[$fieldId] = $value;
        }
        $this->storage->saveFormData($pageId, $formatted);
    }
}