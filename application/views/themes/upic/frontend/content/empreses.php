<main class="<?php if(isset($main_class)){ echo $main_class; } ?>">
        <div class="w-content">    
            
            <h4 class="page-header"><?php echo lang('e_cercador'); ?></h4>
            
            <section class="box search-form">
                <div class="box-header">
                    <?php echo lang('e_filtre'); ?>
                </div>
                <div class="box-content">
                    <p class="box-text"><?php echo lang('e_filtre_full'); ?></p>
                    
                    <form action="" class="empreses-filter">
                        <div class="grid-row">
                            <label for="select_municipi"><?php echo lang('e_municipi'); ?></label>
                            <select name="select_municipi" id="select_municipi">
                            </select>
                        </div>                    
                        <div class="grid-row">
                            <label for="select_poligon"><?php echo lang('e_poligon'); ?></label>
                            <select name="select_poligon" id="select_poligon">
                            </select>
                        </div>
                        <div class="grid-row">
                            <label for="select_activitat"><?php echo lang('e_activitats'); ?></label>
                            <select name="select_activitat" id="select_activitat">
                            </select>
                        </div>
                        <div class="grid-row">
                            <label for="input_search"><?php echo lang('e_nempresa'); ?></label>
                            <input type="text" name="input_search" id="input_search" />
                        </div>
                        <div class="grid-row">
                            <input type="button" class="button button-reverse" id="clear-button" value="<?php echo lang('e_reset'); ?>" />
                        </div>

                    </form>
                </div>
            </section>
            <section class="box search-results">
                <div class="box-header">
                    <?php echo lang('e_results'); ?>    
                </div>
                <div class="box-content">
                    <table class="rwd-table">
                        <thead>
                            <tr>
                                <td><?php echo lang('e_nempresa'); ?></td>
                                <td><?php echo lang('e_municipi'); ?></td>
                            </tr>
                        </thead>
                        <tbody id="activitats-container">
                            
                        </tbody>
                    </table>
                    
                
                </div>
            </section>
        </div>
    </main>