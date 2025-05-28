<?php 
    function buildTree(array $elements, $parentId = null): array {
    $branch = [];
    foreach ($elements as $element) {
        if (!isset($element['ParentId'], $element['CustomerGroupID'])) continue;

        if ($element['ParentId'] == $parentId) {
            $children = buildTree($elements, $element['CustomerGroupID']);
            if (!empty($children)) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }
    return $branch;
}

function renderGroupTree(array $groups, int $level = 0): void {
    $indentPx = $level * 15;
    echo '<ul class="list-group">';
    foreach ($groups as $group) {
        echo '<li class="list-group-item d-flex py-2 mb-2" style="border-radius: 6px; padding-left: ' . $indentPx . 'px;">';
        echo '<input type="checkbox" class="form-check-input me-2" value="' . $group['CustomerGroupID'] . '" name="selectedGroups[]">';
        echo '<span class="me-2">' . $group['CustomerGroupName'] . '</span>';
        echo '<a href="#" class="text-primary text-decoration-none ms-auto" title="Chỉnh sửa">';
        echo '<i class="fa-solid fa-pen-to-square"></i></a>';
        echo '</li>';

        if (!empty($group['children'])) {
            renderGroupTree($group['children'], $level + 1);
        }
    }
    echo '</ul>';
}


?>