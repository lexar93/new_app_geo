<main class="<?php if(isset($main_class)){ echo $main_class; } ?>">
<div class="w-content"> 
            <section class="cerca-info">
                <div class="cerca-breadcrumbs"><p class="cinf-section"><?php echo lang('de_cercador'); ?> / </p><p class="cinf-name nom_comr"><!-- Empresa S.L --></p></div>
                <a href="<?php echo base_url('empreses/'); ?>" class="button button-ghost button-icon"><span class="bicon"><img src="<?php echo base_url('assets/img/svg/triangle-left.svg'); ?>" alt="" title="" /></span><?php echo lang('de_tornar'); ?></a>
                
                <!-- <div class="cerca-nav">
                    <a href="" class="button button-ghost button-icon"><span class="bicon"><img src="<?php echo base_url('assets/img/svg/facebook.svg'); ?>" alt="" title="" /></span>Compartir</a>
                    <a href="" class="button button-ghost button-icon"><span class="bicon"><img src="<?php echo base_url('assets/img/svg/sobre.svg'); ?>" alt="" title="" /></span>Enviar</a>
                    <a href="" class="button button-ghost button-icon"><span class="bicon"><img src="<?php echo base_url('assets/img/svg/info.svg'); ?>" alt="" title="" /></span>Més informació</a>
                </div> -->
            </section>
            

            <section class="cerca-col-1">
                <article class="box box-general-info">
                    <div class="box-header nom_comr">
                        <!-- Empresa S.L -->
                    </div>
                    <div class="box-content">
                         <div class="box-target">
                            <!-- <div class="bt-logo"><img src="assets/img/empresa/logo-empresa.png" alt="Teisa" title="Teisa" /></div> -->
                            <h1 class="nom_comr"><!-- Empresa S.L  --></h1>
                            <div class="bt-contact">
                                <span class="bt-icon"><a href="" class="url_src" target="_blank"><img src="<?php echo base_url('assets/img/svg/web.svg');?>" alt="Web" title="Web"></a></span>
                                <span class="bt-icon"><a href="tel:" class="url_tel"><img src="<?php echo base_url('assets/img/svg/phone.svg');?>" alt="Telefon" title="Telefon"></a>  </span>
                                <!-- <span class="bt-icon"><a href="mailto:" class="_tel"><img src="<?php echo base_url('assets/img/svg/message.svg');?>" alt="Email" title="Email"></a>  </span> -->
                            </div>
                            <h4><?php echo lang('de_activitat'); ?></h4>
                            <p class="actvitat_p"></p>
                         </div>
                         <div class="box-table">
                            <h5><?php echo lang('de_info'); ?></h5>
                            <div class="table-container">
                                <table class="table-rwd">
                                    <tr>
                                        <td><?php echo lang('de_nomfiscal'); ?></td>
                                        <td class="nom_fisc"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('de_adresa'); ?></td>
                                        <td class="adreca"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('de_municipi'); ?></td>
                                        <td class="nom_muni"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('de_cp'); ?></td>
                                        <td class="cp"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('de_pol'); ?></td>
                                        <td class="nom_poli"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('de_web'); ?></td>
                                        <td><a class="url url_src" target="_blank"></a></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('de_tel'); ?></td>
                                        <td class="telf_f"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('de_empleats'); ?></td>
                                        <td class="empleats"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('de_xnegoci'); ?></td>
                                        <td class="facturacio"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('de_any'); ?></td>
                                        <td class="a_fact"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('de_nse'); ?></td>
                                        <td class="nom_suc"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('de_epos'); ?></td>
                                        <td class="prinsuc"></td>
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
            <section class="cerca-col-2">
                <article class="box box-cnae">
                    <div class="box-header">
                        <?php echo lang('de_cnae'); ?>
                    </div>
                    <div class="box-content">
                        <div class="box-table">
                            <div class="table-container">
                                <table class="table-rwd">
                                    <tr>
                                        <td><?php echo lang('de_iae'); ?></td>
                                        <td class="iaeprin"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('de_ccae'); ?></td>
                                        <td class="grup_act"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('de_fjuridica'); ?></td>
                                        <td class="f_jur"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </article>
                <article class="box box-cnae">
                    <div class="box-header">
                        <?php echo lang('de_localitzacio'); ?>
                    </div>
                    <div class="box-content">
                        <div class="box-table">
                            <div class="table-container">
                                <table class="table-rwd">
                                    <tr>
                                        <td><?php echo lang('de_coord84'); ?></td>
                                        <td class="lat"></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo lang('de_coord85'); ?></td>
                                        <td class="long"></td>
                                    </tr>                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </article>
            </section>
        </div>
</main>