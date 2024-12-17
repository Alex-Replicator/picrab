<?php
namespace Picrab\Components\FormConstructor;

use Picrab\Components\Database\Database;

class FormModel
{
    private Database $db;
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getGroupsForPage(int $pageId, int $pageTypeId): array
    {
        $sql = "SELECT fg.* FROM hGtv_form_page_relations pr 
                INNER JOIN hGtv_form_groups fg ON pr.group_id = fg.id
                WHERE pr.page_id = ? AND pr.pagetype_id = ?";
        return $this->db->query($sql, [$pageId, $pageTypeId]);
    }

    public function getFieldsForGroup(int $groupId): array
    {
        $sql = "SELECT * FROM hGtv_form_fields WHERE group_id = ?";
        return $this->db->query($sql, [$groupId]);
    }

    public function getValuesForPage(int $pageId): array
    {
        $sql = "SELECT fv.field_id, fv.value FROM hGtv_form_values fv WHERE fv.page_id = ?";
        $res = $this->db->query($sql, [$pageId]);
        $values = [];
        foreach ($res as $r) {
            $values[$r['field_id']] = $r['value'];
        }
        return $values;
    }

    public function saveValues(int $pageId, array $data): void
    {
        foreach ($data as $fieldId => $value) {
            $check = $this->db->query("SELECT id FROM hGtv_form_values WHERE field_id = ? AND page_id = ? LIMIT 1", [$fieldId, $pageId]);
            if ($check) {
                $this->db->execute("UPDATE hGtv_form_values SET value = ? WHERE id = ?", [$value, $check[0]['id']]);
            } else {
                $this->db->execute("INSERT INTO hGtv_form_values (field_id, page_id, value) VALUES (?, ?, ?)", [$fieldId, $pageId, $value]);
            }
        }
    }
}