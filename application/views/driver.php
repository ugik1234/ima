<section class="content-header">
    <div class="row">
        <div class="col-md-12">
            <div class="pull pull-right">
                <button class="btn btn-info btn-outline-primary" onclick="show_modal_page('<?php echo base_url().'supply/popup/add_driver_model/'; ?>')" ><i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Sopir
                </button>
                <button onclick="printDiv('print-section')" class="btn btn-default btn-outline-primary   pull-right "><i class="fa fa-print  pull-left"></i> Cetak</button>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box" id="print-section">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <?php echo $table_name; ?></h3>
                </div>
                <div class="box-body">
                    <div class="col-md-12 table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <?php
                                    foreach ($table_heading_names_of_coloums as $table_head)
                                    {
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
                                if($driver_list != NULL)
                                {
                                    foreach ($driver_list as $single_driver)
                                    {
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $single_driver->name; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_driver->contact; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_driver->address; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_driver->lisence; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_driver->ref; ?>
                                        </td>
                                        <td>
                                            <?php echo $single_driver->date; ?>
                                        </td>                                   
                                        <td>
                                            <?php echo img(array('width'=>'40','height'=>'40','class'=>'img-circle','src'=>'uploads/drivers/'.$single_driver->cus_picture)); ?>
                                        </td>                                   
                                        <td>
                                            <?php 
                                                if($single_driver->status == 0)
                                                {
                                                    echo "Aktif";
                                                } 
                                                else
                                                {
                                                    echo "Tidak Aktif";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="btn-group pull no-print pull-right">
                                                <button type="button" class="btn btn-info btn-flat">Tindakan</button>
                                                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li onclick="show_modal_page('<?php echo base_url().'supply/popup/edit_drivers_model/'.$single_driver->id; ?>')" ><a href="#"><i class="fa fa-pencil"></i> Lihat</a>
                                                    </li>
                                                    <li><a onclick="confirmation_alert('delete this','<?php echo base_url().'supply/delete/drivers/'.$single_driver->id; ?>')"  href="javascript:void(0)"  href="#"><i class="fa fa-trash-o"></i> Hapus</a>
                                                    </li>
                                                    <?php
                                                        if($single_driver->status != 0)
                                                        {                                   
                                                    ?>
                                                        <li>
                                                            <a onclick="confirmation_alert('this active','<?php echo base_url(); ?>supply/change_status/drivers/<?php echo $single_driver->id; ?>/0')"  href="javascript:void(0)" ><i class="fa fa-minus"></i> Aktifkan</a>
                                                        </li>
                                                        <?php
                                                            }

                                                             if($single_driver->status != 1)
                                                            {       
                                                        ?>
                                                            <li>
                                                                <a onclick="confirmation_alert('this in active','<?php echo base_url(); ?>supply/change_status/drivers/<?php echo $single_driver->id; ?>/1')"  href="javascript:void(0)" ><i class="fa fa-minus"></i> Tidak Aktif</a>
                                                            </li>
                                                        <?php
                                                            }
                                                        ?>
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
</section>
<!-- Bootstrap model  -->
<?php $this->load->view('bootstrap_model.php'); ?>
<!-- Bootstrap model  ends--> 