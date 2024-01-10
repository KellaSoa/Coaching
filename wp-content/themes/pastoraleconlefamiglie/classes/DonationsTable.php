<?php
ob_start();
if (!class_exists('WP_List_Table')) {
    require_once ABSPATH.'wp-admin/includes/class-wp-list-table.php';
}
class DonationsTable extends \WP_List_Table
{
    public array $data = [[]];

    public function get_columns(): array
    {
        return [
            'id'            => 'ID',
            'created_date'  => 'Data donazione',
            'donation'      => 'Importo',
            'orderID'       => 'ID Ordine',
            'fullName'      => 'Nominativo',
            'email'         => 'Email',
            'phone'         => "Telefono",
            'status'        => 'Stato',
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
        $search = isset($_REQUEST['s']) ? sanitize_text_field($_REQUEST['s'])  : '';
        if (!empty($search)) {
            $data = $this->perform_search($data, $search);
        }
        //filter by status donation
        $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
        if (!empty($filter))
            $data = $this->perform_filter_search($data, $filter);
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
    public function perform_search($data, $search)
    {
        $results = array_filter($data, function ($item) use ($search) {
            $search = strtolower($search);
            $found = false;

            // Define the fields you want to search in
            $fields = ['fullName', 'email','phone', 'orderID']; // Add your field names here

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
    public function perform_filter_search($data, $filter){
        $results = array_filter($data, function ($item) use ($filter) {
            $search = strtolower($filter);
            $found = false;

            // Define the fields you want to search in
            $fields = ['status']; //

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
        switch ($item['status'])
        {
            case 'success':
                $status = 'COMPLETATA';
                break;
            case 'failed':
                $status = 'FALLITA';
                break;
            case 'cancelled':
                $status = 'ANNULLATA';
                break;
            default:
                $status= "IN ATTESA";
                break;
        }

        $created_date = '';
        if($item['created_date'] > 0) {
            $date = date_create($item['created_date']);
            $created_date = date_format($date, "d/m/Y H:i:s");
        }

        switch ($column_name) {
            case 'id':
                return sprintf('<a href="%s">#%s</a>', admin_url('admin.php?page=detail_sostienici&id='.$id.'&paged='.$page), esc_html($item['id']));
            case 'fullName':
            case 'orderID':
            case 'email':
            case 'phone':
            case 'donation':
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
            //'delete' => sprintf('<a href="javascript:void(0)"  class="delete-item" data-item-id="%s" data-table="sostienici">Delete</a>', $item['id']),
        ];
        $id = $item['id'];
        $page = $_GET['paged'];
        $fullName= sprintf('<a href="%s">%s</a>', admin_url('admin.php?page=detail_sostienici&id='.$id.'&paged='.$page), $item['fullName']);

        return sprintf('%1$s %2$s', $fullName, $this->row_actions($actions));
    }
    public function get_bulk_actions()
    {
        if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'delete') {
            $item_id = absint($_REQUEST['item']);
            $page = absint($_REQUEST['paged']) ? absint($_REQUEST['paged']) : 1;
            // Delete item in database
            Donation::Instance()->delete_item($item_id);

            // Redirect back to the same page
            wp_redirect(admin_url('admin.php?page=sostienici&paged='.$page));
            exit;
        }
    }
    public function extra_tablenav($which)
    {
        if ($which == 'top') {
            //Add filter By Status inscription
            $status = $_GET['filter'] ?? '';
            $search = $_GET['s'] ?? '';
            ?>
            <form action="">
            <input type="hidden" name="page" value="sostienici">
                <div class="alignleft actions">
                    <label class="screen-reader-text" for="post-query-submit">Search:</label>
                    <input type="search" id="post-query-submit" name="s" value="<?php _admin_search_query(); ?>">
                    <input type="hidden" id="post-filter" name="filter" value="<?php echo $status; ?>">
                    <?php submit_button('Search', '', 'submit', false); ?>
                </div>
            </form>

            <?php

            // Generate the select options
            $options = array(
                ''      =>'Select status',
                'waiting'   => 'IN ATTESA',
                'success'   => 'COMPLETATA',
                'failed'    => 'FALLITA',
                'cancelled' => 'ANNULLATA',
            );
            // Output the select element  $status = 'ANNULLATA';
            ?><form action="">
                <input type="hidden" name="page" value="sostienici">
                <input type="hidden" id="post-query-submit" name="s" value="<?php echo $search; ?>">
            <?php
            echo '<select name="filter">';
            foreach ($options as $key => $value) {
                $selected = $status == $key ?? 'selected="selected"';
                if($selected)
                    echo "<option value='$key' selected>$value</option>";
                else
                    echo "<option value='$key'>$value</option>";

            }
            echo '</select>';

            submit_button(__('Filter'), 'button', 'filter_action', false);
        }
    }

}