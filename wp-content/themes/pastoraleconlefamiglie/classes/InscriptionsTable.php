<?php
ob_start();
if (!class_exists('WP_List_Table')) {
    require_once ABSPATH.'wp-admin/includes/class-wp-list-table.php';
}
class InscriptionsTable extends \WP_List_Table
{
    public array $data = [[]];

    public function get_columns(): array
    {
        return [
            'id' => 'ID',
            'created_date' => 'Data Iscrizione',
            'fullName' => 'Nominativo',
            'email' => 'Mail',
            'course' => 'Nome corso',
            'dateCourse' => 'Date corso',
            'typeInscription' => 'Tipo Iscrizione',
            'status' => 'Stato',
        ];
    }

    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = [];
        $sortable = [];
        $this->_column_headers = [$columns, $hidden, $sortable];
        // Get the data
        $data = $this->data;

        // Set up search functionality
        $search = isset($_REQUEST['s']) ? sanitize_text_field($_REQUEST['s']) : '';
        /*if (!empty($search)) {
            $data = $this->perform_search($data, $search);
        }
        // filter by status inscription
        $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
        if (!empty($filter)) {
            $data = $this->perform_filter_search($data, $filter);
        }*/

        // PAGINATION
        $per_page = 50;
        $current_page = $this->get_pagenum();
        $total_items = count($data);

        // only ncessary because we have sample data
        $this->data = array_slice($data, ($current_page - 1) * $per_page, $per_page);
        $this->set_pagination_args([
            'total_items' => $total_items,                  // WE have to calculate the total number of items
            'per_page' => $per_page,                     // WE have to determine how many items to show on a page
        ]);

        $this->items = $this->data;

    }

    public function extra_tablenav($which)
    {
        if ($which == 'top') {
            $status = $_GET['filter'] ?? '';
            $search = $_GET['s'] ?? '';
            // Output your search box here
            ?>
            <form action="">
                <input type="hidden" name="page" value="iscrizioni">
                <div class="alignleft actions">
                    <label class="screen-reader-text" for="post-query-submit">Search:</label>
                    <input type="search" id="post-query-submit" name="s" value="<?php echo $search; ?>">
                    <input type="hidden" id="post-filter" name="filter" value="<?php echo $status; ?>">
                    <?php submit_button('Search', '', 'submit', false); ?>
                </div>
            </form>

            <?php

            // Generate the select options
            $options = [
                '' => 'Seleziona stato',
                'new'       => 'DA LEGGERE',
                'waiting'   => 'IN ATTESA',
                'success'   => 'CONFERMATA',
                'failed'    => 'ANNULLATA',
            ];
            // Output the select element
            ?><form action="">
                <input type="hidden" name="page" value="iscrizioni">
                <input type="hidden" id="post-seach" name="s" value="<?php echo $search; ?>">
            <select name="filter">
            <?php foreach ($options as $key => $value) {
                $selected = $status == $key ?? 'selected="selected"';
                if($selected)
                    echo "<option value='$key' selected>$value</option>";
                else
                    echo "<option value='$key'>$value</option>";
            } ?>
            </select>

            <?php
            submit_button(__('Filter'), 'button', 'filter_action', false);
            ?>
            <div class="w-100">
                <div class="alignright actions mb-2">
                    <a target="_blank" href="<?php echo admin_url('admin-ajax.php?action=export_csv&filter='.$status.'&s='.$search);?>" class="button button-primary button-large" style="width: 100%; text-align:center">EXPORT ISCRIZIONI</a>
                </div>
               <div class=" alignright actions mb-2">
                    <a  target="_blank" href="<?php echo admin_url('admin-ajax.php?action=export_accoglienza&filter='.$status.'&s='.$search);?>" class="button button-primary button-large" style="width: 100%; text-align:center">EXPORT ACCOGLIENZA</a>
               </div>
                <div class=" alignright actions mb-2">
                    <a target="_blank" href="<?php echo admin_url('admin-ajax.php?action=export_csv_children&filter='.$status.'&s='.$search); ?>" class="button button-primary button-large" style="width: 100%; text-align:center">EXPORT ASSICURAZIONE BAMBINI</a>
                </div>

            </div>
            <div class="clear">

            </div>

            <?php
        }
    }

    // column search in table wp_list_table
    public function perform_search($data, $search)
    {
        $results = array_filter($data, function ($item) use ($search) {
            $search = strtolower($search);
            $found = false;

            // Define the fields you want to search in
            $fields = ['fullName', 'email', 'course', 'status', 'dateCourse']; // Add your field names here

            foreach ($fields as $field) {
                $fieldValue = strtolower($item[$field]);
                if (strpos($fieldValue, $search) !== false) {
                    $found = true;
                    break;
                }
            }

            return $found;
        });

        return $results;
    }

    public function column_default($item, $column_name)
    {
        $id = $item['id'];
        $page = $_GET['paged'];
        if ($item['status'] == 'success') {
            $status = 'CONFERMATA';
        } elseif ($item['status'] == 'failed') {
            $status = 'ANNULLATA';
        }elseif ($item['status'] == 'waiting') {
            $status = 'IN ATTESA';
        }
        else {
            $status = 'DA LEGGERE';
        }
        $created_date = '';
        if ($item['created_date'] > 0) {
            $date = date_create($item['created_date']);
            $created_date = date_format($date, 'd/m/Y H:i:s');
        }

        switch ($column_name) {
            case 'id':
                return sprintf('<a href="%s">#%s</a>', admin_url('admin.php?page=detail_iscrizione&id='.$id.'&paged='.$page), esc_html($item['id']));

            case 'fullName':
            case 'typeInscription':
            case 'email':
            case 'course':
            case 'dateCourse':
                return $item[$column_name];
            case 'status':
                return '<span class="'.$item['status'].'">'.$status.'</span>';
            case 'created_date':
                return $created_date;
            default:
                return print_r($item, true); // Show the whole array for troubleshooting purposes
        }
    }

    public function column_fullName($item)
    {
        $actions = [
            // 'edit' => sprintf('Edit', $_REQUEST['page'], 'edit', $item['ID']),
            //'delete' => sprintf('<a href="javascript:void(0)"  class="delete-item" data-item-id="%s" data-table="iscrizioni">Delete</a>', $item['id']),
        ];
        $id = $item['id'];
        $page = $_GET['paged'];
        $fullName = sprintf('<a href="%s">%s</a>', admin_url('admin.php?page=detail_iscrizione&id='.$id.'&paged='.$page), $item['fullName']);

        return sprintf('%1$s %2$s', $fullName, $this->row_actions($actions));
    }

    public function get_bulk_actions()
    {
        if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'delete') {
            $item_id = absint($_REQUEST['item']);
            $page = absint($_REQUEST['paged']) ? absint($_REQUEST['paged']) : 1;
            // Delete item in database
            UserInscription::Instance()->delete_item($item_id);

            // Redirect back to the same page
            wp_redirect(admin_url('admin.php?page=iscrizioni&paged='.$page));
            exit;
        }
    }

    public function perform_filter_search($data, $filter)
    {
        $results = array_filter($data, function ($item) use ($filter) {
            $search = strtolower($filter);
            $found = false;

            // Define the fields you want to search in
            $fields = ['status'];
            foreach ($fields as $field) {
                $fieldValue = strtolower($item[$field]);
                if (strpos($fieldValue, $search) !== false) {
                    $found = true;
                    break;
                }
            }

            return $found;
        });

        return $results;
    }

}
