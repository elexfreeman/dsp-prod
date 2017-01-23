
<div class="container patient-search-container">
    <div class="panel  patient-search-container panel-bordered panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Поиск пациентов</h3>
        </div>
        <div class="panel-body">
            <form>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-1">
                                <div class="media-left">
									<span class="icon-wrap icon-wrap-sm icon-circle bg-success">
									<i class="fa fa-hospital-o fa-2x"></i>
									</span>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <p class="text-2x mar-no text-thin">Выберите ЛПУ</p>
                                <!-- Default choosen -->
                                <!--===================================================-->
                                <select data-placeholder="Choose a Country..." id="lpu-select" tabindex="2">
                                    <option value="-" selected>-</option>
                                    <?php
                                   /*
                                    foreach ($lpu_list as $lpu) {
                                        ?>
                                        <option value="<?php echo $lpu->LPUCODE ?>"><?php echo $lpu->LPUCODE." | ".$lpu->NAME; ?></option>
                                    <?php
                                    }*/


                                    ?>


                                </select>
                                <!--===================================================-->
                            </div>
                        </div>
                        <hr>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>

</div>