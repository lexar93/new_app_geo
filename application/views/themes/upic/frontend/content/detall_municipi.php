<main class="<?php if(isset($main_class)){ echo $main_class; } ?>">
<div class="w-content"> 
            <section class="cerca-info">
                <div class="cerca-breadcrumbs"><p class="cinf-section"><?php echo lang('dm_municipis'); ?> / </p><p class="cinf-name nom_mun"><!-- Empresa S.L --></p></div>
                
                <!-- <div class="cerca-nav">
                    <a href="" class="button button-ghost button-icon"><span class="bicon"><img src="<?php echo base_url('assets/img/svg/facebook.svg'); ?>" alt="" title="" /></span>Compartir</a>
                    <a href="" class="button button-ghost button-icon"><span class="bicon"><img src="<?php echo base_url('assets/img/svg/sobre.svg'); ?>" alt="" title="" /></span>Enviar</a>
                    <a href="" class="button button-ghost button-icon"><span class="bicon"><img src="<?php echo base_url('assets/img/svg/info.svg'); ?>" alt="" title="" /></span>Més informació</a>
                </div> -->
            </section>
            

            <section class="cerca-col">
                <article class="box box-general-info">
                    <div class="box-header nom_mun">

                    </div>
                    <div class="box-content">

                        <div class="box-target">
                            <div class="bt-escut"><img class="municipi_img" src="" alt="" /></div>
                            <h1 class="nom_mun"><!-- Empresa S.L  --></h1>
                            <div class="bt-contact">
                                <span class="bt-icon"><a href="" class="url_src" target="_blank"><img src="<?php echo base_url('assets/img/svg/web.svg');?>" alt="Web" title="Web"></a></span>
                            </div>
                        </div>
                        <div class="box-description">
                            <h5><?php echo lang('dm_desc'); ?></h5>
                            <div class="descrip"></div>
                        </div>
                        <div class="box-table">
                            <h5><?php echo lang('dm_info'); ?></h5>
                            <div class="table-container">
                                <table class="table-rwd">
                                    <tr>
                                        <td><?php echo lang('dm_habitants'); ?></td>
                                        <td class="habitants"></td><!-- Calcular -->
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('dm_poligons'); ?></td>
                                        <td class="tot_pol"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('dm_establiments'); ?></td>
                                        <td class="tot_est"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('dm_web'); ?></td>
                                        <td><a href="" class="url url_src" target="_blank"></a></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('dm_cp'); ?></td>
                                        <td class="codi_mun"></td>
                                    </tr>
                                </table>
                            </div>
                            <!-- <div class="align-button">
                                    <a href="" class="button button-reverse">Veure mapa</a>                            
                            </div>     -->
                        </div>
                    </div>
                </article>
            </section>
            <!-- <section class="cerca-col-2">
                <article class="box">
                    <div class="box-header">
                        Descripció
                    </div>
                    <div class="box-content">
                        <div class="descrip">

                        </div>
                    </div>
                </article>
            </section> -->
        </div>
</main>