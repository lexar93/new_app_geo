<section class="acceso">     
    <div class="featured-login">
        
    </div>
    <div class="register-form">
        <div class="form-content">
            <div class="form-content--table-cell">
                <a class="logo  mgb-20" href="<?php echo base_url($this->lang->lang().'/Principal'); ?>"><img height="47px;" src= "<?php echo base_url('assets/img/logos/logo.jpg'); ?>" alt="<?php echo lang('App_name');?>" title="<?php echo lang('App_name');?>"/></a>
                <h2 class="section-header"><?php echo lang('Accede a tu cuenta');?></h2>
                <form id="formlogin" autocomplete="off" method="post" >                  
                    <div class="pdt-20 pdb-10">     
                        <label for="identity"><?php echo lang('Email');?></label>
                        <input type="email" id="identity" name="identity" />
                    </div>
                    <div class="pdt-10 pdb-10">         
                        <label for="password"><?php echo lang('Password');?></label>                        
                        <input type="password" id="password" name="password" />
                    </div>
                    <div class="pdt-10 pdb-20">     
                        <a href="<?php echo base_url($this->lang->lang().'/auth/forgot_password'); ?>"><?php echo lang('¿Olvidaste la contraseña?');?></a>
                    </div>
                    <div id="infoMessage"><?php if(isset($message)) echo $message;?></div>
                    <div class="pdt-20 pdb-20">                          
                        <input id="btnsubmit" type="submit" class="btn btn-big"  value="<?php echo lang('Access');?>" />
                    </div>                   
                </form>
                <script>
                    jQuery.validator.setDefaults({
                    debug: true,
                    success: "valid"
                    });
                    $("#formlogin").validate({
                        rules: {
                            email: { required: true},
                            password: { required: true},                            
                        },
                        messages:{                           
                            email: { required: "<?php echo lang('mand_email')?>", email: '<?php echo lang('valid_email')?>' },
                            password: { required: "<?php echo lang('mand_password')?>" },                            
                        },
                        submitHandler: function (form) {
                            login();
                        }                           
                    });
                </script>   
            </div>
        </div>  
    </div>
</section>
