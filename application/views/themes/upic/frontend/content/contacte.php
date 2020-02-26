    <main class="<?php if(isset($main_class)){ echo $main_class; } ?>">
        <section class="inner-hero" style="">
            <div class="w-content">
                <h2><?php echo lang('Contacta_nosaltres'); ?></h2>
            </div>
        </section>
        <div>
            <div class="w-content">
                <section class="contact-form">
                    <div class="box">
                        <div class="box-header">
                            <?php echo lang('Contact_header'); ?>
                        </div>
                        <div class="box-content">
                            <p class="box-text"><?php echo lang('Contact_info'); ?></p>    
                        
                            <form action="" id="sendEmail" class="grid-form" method="POST">
                                <div class="grid-row">
                                    <div class="grid-md-6 grid-nopd-l">
                                        <label for="name"><?php echo lang('Name'); ?>*</label>
                                        <input type="text" required name="name" id="name" value="">
                                    </div>
                                    <div class="grid-md-6 grid-nopd-r">
                                        <label for="surname"><?php echo lang('Surname'); ?>*</label>
                                        <input type="text" required name="surname" id="surname" value="">
                                    </div>
                                </div>
                                <div class="grid-row">
                                    <div class="grid-md-6 grid-nopd-l">
                                        <label for="email"><?php echo lang('Email'); ?>*</label>
                                        <input type="text" required name="email" id="email" value="">
                                    </div>
                                    <div class="grid-md-6 grid-nopd-r">
                                        <label for="phone"><?php echo lang('Telephone'); ?></label>
                                        <input type="text" name="phone" id="phone" value="">
                                    </div>
                                </div>
                                <div class="grid-row">
                                    <div class="grid-xs-12">
                                        <label for="phone"><?php echo lang('Company'); ?></label>
                                        <input type="text" name="company" id="company" value="">
                                    </div>
                                </div>
                                <div class="grid-row">
                                    <div class="grid-xs-12">
                                        <label for="message"><?php echo lang('Message'); ?>*</label>
                                        <textarea type="text" name="message" id="message" value=""></textarea>
                                    </div>
                                </div>
                                <div class="grid-row">
                                    <div class="grid-xs-12">
                                        <label class="text-small"><input class="normal-checkbox" type="checkbox" name="confirm" id="confirm"><span></span><?php echo lang('Contact_politics'); ?></label>
                                    </div>
                                </div>
                                <div class="grid-row">
                                    <div class="grid-xs-12">
                                        <input class="button button-reverse button-big" type="button" id="enviar" onclick="return sendEmail();" name="submit" value="<?php echo lang('Enviar Formulari'); ?>">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div> 
                </section>
                <section class="contact-info">
                    <div class="box">
                        <div class="box-header">
                            <?php echo lang('Dades_Contacte'); ?>
                        </div>
                        <div class="box-content">
                            <ul class="list-2-cols box-text">
                                <li><?php echo lang('Email'); ?></li>
                                <li><a href="<?php echo lang('f_mailto'); ?>"><?php echo lang('f_mail'); ?></a></li>
                                <li><?php echo lang('Telephone'); ?></li>
                                <li><?php echo lang('f_telf'); ?></li>
                                <li><?php echo lang('Address'); ?></li>
                                <li><?php echo lang('f_address_full'); ?></li>
                                <li><?php echo lang('Networks'); ?></li>
                                <li><a href="<?php echo lang('f_facebook'); ?>" target="_blank"><img src="<?php echo base_url('assets/img/svg/facebook_color.svg'); ?>" alt="Facebook"></a><a href="<?php echo lang('f_twitter'); ?>" target="_blank"><img src="<?php echo base_url('assets/img/svg/twitter_color.svg'); ?>" alt="Twitter"></a></li>
                            </ul>           
                        </div>
                    </div>     
                </section>
            </div>            
        </div>
    </main>

<script>
    
function sendEmail(e){
    var titol = '<?php echo lang('sms_ok'); ?>';
    var desc = '<?php echo lang('desc_ok'); ?>';

    if($("#name").val()!=="" && $("#surname").val()!=='' && $("#email").val()!=='' && $("#message").val()!=='' && $('#confirm').prop('checked') ){ 
        
        $.ajax({
            type: 'POST',
            data: $('#sendEmail').serialize(),
            url: base_url+'contacte/sendEmail/',
            success: function(data){
                if(data.result=="true"){  
                    swal('<h3>'+titol+'</h3>', desc,'success').catch(swal.noop);
                    $("#sendEmail")[0].reset();      
                    return true; 
                }
                else{                    
                    swal('<strong>Uupps! </strong>', data.detail,'warning').catch(swal.noop);           
                    return false;           
                }   
            }
        });
    }else{
        return false;
    }
}

</script>