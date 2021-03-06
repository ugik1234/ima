 <div class="card card-custom" id="print-section">
     <div class="card-body">

         <div class="col-md-12">
             <div class="pull pull-right">
                 <button type="button" class="btn btn-info btn-outline-primary" onclick="show_modal_page('<?php echo base_url() . 'accounts/popup/add_chart_of_accounts'; ?>')"><i class="fa fa-plus-square" aria-hidden="true"></i> Buat Akun
                 </button>
                 <!-- <button onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary   pull-right "><i class="fa fa-print  pull-left"></i> Cetak</button> -->
                 <a href="<?= base_url() ?>download/chart_of_account" class="btn btn-default btn-outline-primary  pull-right "><i class="fa fa-download  pull-left"></i> Excel</a>
             </div>
         </div>
     </div>
 </div>
 <div class="card card-custom">
     <div class="card-body">
         <div class="col-xs-12">
             <div class="box" id="print-section">
                 <div class="box-header">
                     <h3 class="box-title"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Daftar Akun </h3>
                 </div>
                 <div class="box-body">
                     <div class="table-responsive col-md-12">
                         <table class="table table-bordered table-hover table-checkable mt-10" id="FDataTable">
                             <thead>
                                 <?php
                                    foreach ($table_heading_names_of_coloums as $table_head) {
                                    ?>
                                     <th>
                                         <?php echo $table_head; ?>
                                     </th>
                                 <?php
                                    }
                                    ?>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                    if ($chart_list != NULL) {
                                        foreach ($chart_list as $single_account) {
                                    ?>
                                         <tr>
                                             <td style="text-align: left;">
                                                 <?php echo $single_account->name; ?>
                                             </td>
                                             <td>
                                                 <?php echo $single_account->nature; ?>
                                             </td>
                                             <td>
                                                 <?php echo $single_account->type; ?>
                                             </td>
                                             <td>
                                                 <?php echo $single_account->relation_id; ?>
                                             </td>
                                             <td>
                                                 <?php echo $single_account->expense_type; ?>
                                             </td>
                                             <td>
                                                 <div class="btn-group pull no-print pull-right">
                                                     <button type="button" class="btn btn-info btn-flat">Tindakan</button>
                                                     <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                         <span class="caret"></span>
                                                         <span class="sr-only">Toggle Dropdown</span>
                                                     </button>
                                                     <ul class="dropdown-menu" role="menu">
                                                         <li onclick="show_modal_page('<?php echo base_url() . 'accounts/popup/edit_chart_of_accounts/' . $single_account->id; ?>')"><a href="#"> <i class="fa fa-pencil"></i>
                                                                 Edit </a>
                                                         </li>
                                                         <li onclick="confirmation_alert('delete this head','<?php echo base_url() . 'accounts/delete/' . $single_account->id; ?>')">
                                                             <i class="fa fa-trash-o"></i> Hapus
                                                         </li>
                                                     </ul>
                                                 </div>
                                             </td>
                                         </tr>
                                 <?php
                                        }
                                    }
                                    ?>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <script>
     $('#menu_id_23').addClass('menu-item-active menu-item-open menu-item-here"')
     $('#submenu_id_58').addClass('menu-item-active')
     $(document).ready(function() {

         var FDataTable = $('#FDataTable').DataTable({
             'columnDefs': [],
             deferRender: true,
             "order": [
                 [0, "asc"]
             ]
         });
     });
 </script>
 <!-- Bootstrap model  -->
 <?php $this->load->view('bootstrap_model.php'); ?>
 <!-- Bootstrap model  ends-->