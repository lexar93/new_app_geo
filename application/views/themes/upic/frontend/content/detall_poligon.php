<main class="<?php if(isset($main_class)){ echo $main_class; } ?>">
<div class="w-content"> 
            <section class="cerca-info">
                <div class="cerca-breadcrumbs"><p class="cinf-section"><?php echo lang('dp_cercador'); ?> / </p><p class="cinf-name nom_pol"><!-- Empresa S.L --></p></div>
                <a href="<?php echo base_url('poligons/'); ?>" class="button button-ghost button-icon"><span class="bicon"><img src="<?php echo base_url('assets/img/svg/triangle-left.svg'); ?>" alt="" title="" /></span><?php echo lang('dp_tornar'); ?></a>
                
                <!-- <div class="cerca-nav">
                    <a href="" class="button button-ghost button-icon"><span class="bicon"><img src="<?php echo base_url('assets/img/svg/facebook.svg'); ?>" alt="" title="" /></span>Compartir</a>
                    <a href="" class="button button-ghost button-icon"><span class="bicon"><img src="<?php echo base_url('assets/img/svg/sobre.svg'); ?>" alt="" title="" /></span>Enviar</a>
                    <a href="" class="button button-ghost button-icon"><span class="bicon"><img src="<?php echo base_url('assets/img/svg/info.svg'); ?>" alt="" title="" /></span>Més informació</a>
                </div> -->
            </section>
            

            <section class="cerca-col-1">
                <article class="box box-general-info">
                    <div class="box-header nom_pol">

                    </div>
                    <div class="box-content">
                        <div class="box-table">
                            <h5><?php echo lang('dp_info'); ?></h5>
                            <div class="table-container">
                                <table class="table-rwd">
                                    <tr>
                                        <td><?php echo lang('dp_nomact'); ?></td>
                                        <td class="tot_act"></td><!-- Calcular -->
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('dp_sol'); ?></td>
                                        <td class="superf"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('dp_sostre'); ?></td>
                                        <td class="sostre"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('dp_se'); ?></td>
                                        <td class="sup_edi"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('dp_empleats'); ?></td>
                                        <td class="tot_emp"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('dp_ocupacio'); ?></td>
                                        <td class="tot_ocup"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('dp_uc'); ?></td>
                                        <td class="tot_ua"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('dp_solars'); ?></td>
                                        <td class="tot_sol"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('dp_any'); ?></td>
                                        <td class="any_crea"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('dp_municipi'); ?></td>
                                        <td class="nom_mun"></td>
                                    </tr>
                                    <!-- <tr>
                                        <td>Xifra de negoci:</td>
                                        <td class=""></td>
                                    </tr> -->
                                </table>
                            </div>
                            <!-- <div class="align-button">
                                    <a href="" class="button button-reverse">Veure mapa</a>                            
                            </div>     -->
                        </div>
                    </div>
                </article>
            </section>
            <section class="cerca-col-2">
                <article class="box box-cnae">
                    <div class="box-header">
                        <?php echo lang('dp_activitats'); ?>
                    </div>
                    <div class="box-image">
                       <img src="" class="rgrafic" alt="<?php echo lang('dp_activitats'); ?>">
                    </div>
                </article>
            </section>
        </div>
</main>