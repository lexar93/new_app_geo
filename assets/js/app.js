'use strict';

//var baseUrl = 'http://upic.wancora.cat/';

$(document).ready(function(){
    //Inicialización de funciones
    responsiveMenu();
    mapMenu();
    customSelect();
    //cookiesInit();
    //swiperInit();
});

function responsiveMenu(){
    $("#burger-menu").on("click", function(){
        $('header').toggleClass("menu-open");
        $('#burger-menu').toggleClass("menu-open");
        $('.menu-mobile-bg').toggleClass("menu-open");
    });

    $('.menu-mobile-bg').on("click", function(){
        $('header').toggleClass("menu-open");
        $('#burger-menu').toggleClass("menu-open");
        $('.menu-mobile-bg').toggleClass("menu-open");
    });

    $('.has-children > a').on('click', function(e){
        e.preventDefault();
        $(this).closest('.has-children').toggleClass('active');
        $(this).next('.submenu').slideToggle();
    })
};

function mapMenu(){
    if($('.map-menu').length){

        if($(window).width()< 600){
            actionMenu();
        }else{
            mapWidth($('.map-menu-area').width());
        }

        $('.map-menu-toggle').on("click", function(){
            actionMenu();
        });

        $(window).resize(function () {
            waitForEvent(function(){
                $('.map-menu-area').addClass('menu-closed');
                actionMenu();
            }, 100, "01");
        });

        function actionMenu(){
            var width = $('.map-menu-area').width();
            if($('.map-menu-area').hasClass('menu-closed')){
                $('.map-menu-area').css('right',0);
                $('.map-menu-area').removeClass('menu-closed');
                setTimeout(function() {mapWidth(width)},200);
            }else{
                $('.map-menu-area').css('right',-width+5);
                $('.map-menu-area').addClass('menu-closed');
                $('.map-menu .legend').removeClass('menu-open');
                $('.map-menu .legend-bg').removeClass('menu-open');
                mapWidth(width);
            }
        }

        function mapWidth(width){
            if(!$('.map-menu-area').hasClass('menu-closed')){
                if($(window).width()>600){
                    $('#map').css('margin-right', width);
                    resizeMap();
                }
            }else{
                if($(window).width()>600){
                    $('#map').css('margin-right', 0);
                    resizeMap();
                }
            }
        }
    }

    if($('.select-map-ctrls').length){
        $(window).resize(function () {
            waitForEvent(function(){
                positionMaps();
            }, 100, "01");
        });

        positionMaps();
    }

    if($('.map-menu .legend').length){
        $('.map-menu .legend-toggle').on('click', function(){
            $('.map-menu .legend').addClass('menu-open');
            $('.map-menu .legend-bg').addClass('menu-open');
        });

        $('.map-menu .close-legend').on('click', function(){
            $('.map-menu .legend').removeClass('menu-open');
            $('.map-menu .legend-bg').removeClass('menu-open');
        });
    }
}

function positionMaps(){
    if($('.map-menu-content').height() + 150 < $('.map-menu').height()){
        $('.select-map-ctrls').css({
            position: "absolute"
        });
    }else{
        $('.select-map-ctrls').css({
            position: "relative"
        });
    }
}

var waitForEvent = (function() {
  var timers = {};
  return function (callback, ms, id) {
    if (timers[id]) {
      clearTimeout (timers[id]);
    }
    timers[id] = setTimeout(callback, ms);
  };
})();

function customSelect(){
    $('select').select2({width: '100%'});
};

function modalAlert(activ){
    var active = activ || false;
    
    if(active===true){
        $('.modal-alert-full').addClass('active');
        $('.modal-alert-full').find('.ok-button').on("click", function(e){
            e.preventDefault();
            modalAlert(false);
        })
    }else{
        $('.modal-alert-full').removeClass('active');
    }

    $('.modal-bg').on("click", function(){
        modalAlert(false);
    });
}


function filterMenuOptions(){
    $('.menu-options .button').on('click', function(e){
        e.preventDefault();
        var value = $(this).data("value");
        if( value != 'all'){
            $('tr').not('.header').hide();
            $('tr.'+value).show();
        }else{
            $('tr').show();
        }

        $('.menu-options .button').removeClass('active');
        $(".menu-options .button[data-value='"+value+"']").addClass('active');
    })
}

function swiperInit(){
    if($('.swiper-container').length){
        var swiper = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            slidesPerView: 1,
            paginationClickable: true,
            speed: 1000,
            spaceBetween: 1000,
            autoplay: 4500,
            loop: true
        });
    }
}

function uniqueV(myjson, mySearch){
    var lng = myjson.length,
        temp = {},
        vals = [];        
        
        if(mySearch.parentKey!=undefined){
            for (var i = 0; i < lng; i++) {
                if(myjson[i].properties[mySearch.parentKey]===mySearch.parentValue){
                    var id = myjson[i].properties[mySearch.id];
                    if (!(id in temp)) {
                        temp[id] = 1;
                        vals.push({id : id, name: myjson[i].properties[mySearch.name]});
                    }
                }
            }
        }else{
            for (var i = 0; i < lng; i++) {
                var id = myjson[i].properties[mySearch.id];
                if (!(id in temp)) {
                    temp[id] = 1;
                    vals.push({id : id, name: myjson[i].properties[mySearch.name]});
                }
            }
        };

    return  vals.sort(function(a, b) {
        if (a.name > b.name) { 
            return 1;
        }else{
            return -1;
        }
    });
}

function fillSelect(id, array, word){
    var contentDiv = '<option value="0">'+word+'</option>',
        lng = array.length;

    for(var i=0; i<lng; i++){
        contentDiv += '<option value="'+array[i].id+'">'+array[i].name+'</option>';
    }

    document.getElementById(id).innerHTML = contentDiv;
};


function empresesFilter(){
    if($('.empreses-filter').length){
        var myjson = json_empreses.features,
            municipi = uniqueV(myjson, {name:"nom_muni",id:"id_mun"}),
            poligon = uniqueV(myjson,{name:"nom_poli",id:"id_poli"}),
            activitat = uniqueV(myjson, {name:"grup_act",id:"idact"});
            
        myjson = myjson.sort(function(a, b) {
            if (a.properties.nom_comr > b.properties.nom_comr) { 
                return 1;
            }else{
                return -1;
            }
        });

        fillSelect('select_municipi',municipi,'Tots');
        fillSelect('select_poligon',poligon,'Tots');
        fillSelect('select_activitat',activitat,'Totes');
        
        $('#select_municipi').on('select2:select', function (e) {
            var val = e.params.data.id,
                text = document.getElementById("input_search").value;

            if(val != 0){
                var pol_red = uniqueV(myjson, {name:"nom_poli",id:"id_poli", parentKey:"id_mun", parentValue: val});   
                fillSelect('select_poligon',pol_red,'Tots');
                var act_red = uniqueV(myjson, {name:"grup_act",id:"idact", parentKey:"id_mun", parentValue: val});   
                fillSelect('select_activitat',act_red,'Totes');
                reduceEmpresa(myjson);
            }else if(text!==""){
                fillSelect('select_poligon',poligon,'Tots');
                fillSelect('select_activitat',activitat,'Totes');
                reduceEmpresa(myjson);
            }else{
                fillSelect('select_poligon',poligon,'Tots');
                fillSelect('select_activitat',activitat,'Totes');
                fillActivitat(myjson);
            }
        });

        $('#select_poligon').on('select2:select', function (e) {
            var val = e.params.data.id;

            if(val != 0){
                var act_red = uniqueV(myjson, {name:"grup_act",id:"idact", parentKey:"id_poli", parentValue: val});   
                fillSelect('select_activitat',act_red,'Totes');
                reduceEmpresa(myjson);
            }else{
                fillSelect('select_activitat',activitat,'Totes');
                reduceEmpresa(myjson);
            }
        });

        $('#select_activitat').on('select2:select', function (e) {
            reduceEmpresa(myjson);
        });

        document.getElementById("input_search").onkeyup = function(){
            reduceEmpresa(myjson);
        }

        document.getElementById("clear-button").onclick = function(){
            fillSelect('select_municipi',municipi,'Tots');
            fillSelect('select_poligon',poligon,'Tots');
            fillSelect('select_activitat',activitat,'Totes');
            document.getElementById("input_search").value = "";
            fillActivitat(myjson);
        }

        fillActivitat(myjson);
    }
}

function reduceEmpresa(myJson){
    var mun = $('#select_municipi').select2('data'),
        pol = $('#select_poligon').select2('data'),
        act = $('#select_activitat').select2('data'),
        text = document.getElementById("input_search").value;

        var redJson = myJson.filter(function(empresa){
            var munCheck = true,
                polCheck = true,
                actCheck = true,
                nomCheck = true; 

            if(mun[0].id != 0 && mun[0].id != empresa.properties.id_mun){
                munCheck = false
            } 

            if(pol[0].id != 0 && pol[0].id != empresa.properties.id_poli){
                polCheck = false
            }
            if(act[0].id != 0 && act[0].id != empresa.properties.idact){
                actCheck = false
            }
            if(text != "" && empresa.properties.nom_comr.toUpperCase().indexOf(text.toUpperCase()) === -1){
                nomCheck = false
            }
            return munCheck && polCheck && actCheck && nomCheck;
        })

        fillActivitat(redJson);
}

function fillActivitat(myJson){
    var contentDiv = '',
        lng = myJson.length;

    for(var i=0; i<lng;i++){
        contentDiv += '<tr>';
        contentDiv += '<td><a href="'+base_url+'empreses/detall_empresa/'+myJson[i].properties.id_emp+'">';
        contentDiv += myJson[i].properties.nom_comr+'</a></td>';
        contentDiv += '<td>'+myJson[i].properties.nom_muni+'</td>';
        contentDiv += '<tr>';
    }   

    document.getElementById('activitats-container').innerHTML = contentDiv;

}

function poligonsFilter(){
    if($('.poligons-filter').length){
        var myjson = json_infopoligons.features,
            municipi = uniqueV(myjson, {name:"nom_mun",id:"id_mun"}),
            poligon = uniqueV(myjson,{name:"nom_pol",id:"id_pol"});
            
        myjson = myjson.sort(function(a, b) {
            if (a.properties.nom_pol > b.properties.nom_pol) { 
                return 1;
            }else{
                return -1;
            }
        });

        fillSelect('select_municipi',municipi,'Tots');
        fillSelect('select_poligon',poligon,'Tots');
        
        $('#select_municipi').on('select2:select', function (e) {
            var val = e.params.data.id;

            if(val != 0){
                var pol_red = uniqueV(myjson, {name:"nom_poli",id:"id_poli", parentKey:"id_mun", parentValue: val});   
                fillSelect('select_poligon',pol_red,'Tots');
                reducePoligon(myjson);
            }else{
                fillSelect('select_poligon',poligon,'Tots');
                fillPoligon(myjson);
            }
        });

        $('#select_poligon').on('select2:select', function (e) {
            reducePoligon(myjson);
        });

        document.getElementById("input_search").onkeyup = function(){
            reducePoligon(myjson);
        }

        document.getElementById("clear-button").onclick = function(){
            fillSelect('select_municipi',municipi,'Tots');
            fillSelect('select_poligon',poligon,'Tots');
            document.getElementById("input_search").value = "";
            fillPoligon(myjson);
        }

        fillPoligon(myjson);
    }
}

function reducePoligon(myJson){
    var mun = $('#select_municipi').select2('data'),
        pol = $('#select_poligon').select2('data'),
        text = document.getElementById("input_search").value;

        var redJson = myJson.filter(function(poligon){
            var munCheck = true,
                polCheck = true,
                nomCheck = true; 

            if(mun[0].id != 0 && mun[0].id != poligon.properties.id_mun){
                munCheck = false
            } 

            if(pol[0].id != 0 && pol[0].id != poligon.properties.id_pol){
                polCheck = false
            }
            if(text != "" && poligon.properties.nom_pol.toUpperCase().indexOf(text.toUpperCase()) === -1){
                nomCheck = false
            }
            return munCheck && polCheck && nomCheck;
        })

        fillPoligon(redJson);
}


function fillPoligon(myJson){
    var contentDiv = '',
        lng = myJson.length;

    for(var i=0; i<lng;i++){
        contentDiv += '<tr>';
        contentDiv += '<td><a href="'+base_url+'poligons/detall_poligon/'+myJson[i].properties.id_pol+'">';
        contentDiv += myJson[i].properties.nom_pol+'</a></td>';
        contentDiv += '<td>'+myJson[i].properties.nom_mun+'</td>';
        contentDiv += '<tr>';
    }   

    document.getElementById('poligons-container').innerHTML = contentDiv;

}


function fillSingleActivitat(id){
    var myjson = json_empreses.features,
        empresa;        

        empresa = myjson.filter(function(emp){
            var check = (emp.properties.id_emp == id) ? true : false;
            return check;
        })

        if(empresa.length == 0){
            document.location = base_url+"empreses/";
        }

        empresa = empresa[0].properties;

        document.querySelectorAll('.nom_comr').forEach(function(el){ el.innerHTML = empresa.nom_comr;});
        document.querySelectorAll('.nom_fisc').forEach(function(el){ el.innerHTML = empresa.nom_fisc;});
        document.querySelector('.actvitat_p').innerHTML = empresa.actvitat_p;
        document.querySelector('.adreca').innerHTML = empresa.adreca;
        document.querySelector('.nom_poli').innerHTML = empresa.nom_poli;
        document.querySelector('.url').innerHTML = empresa.url;
        document.querySelector('.telf_f').innerHTML = empresa.telf_f;
        document.querySelectorAll('.url_src').forEach(function(el){ el.href = empresa.url; })
        document.querySelector('.url_tel').href= "tel:"+empresa.telf_f.replace(/ /g,'');
        document.querySelector('.empleats').innerHTML = empresa.empleats;
        document.querySelector('.facturacio').innerHTML = empresa.facturacio;
        document.querySelector('.a_fact').innerHTML = empresa.a_fact;
        document.querySelector('.nom_suc').innerHTML = empresa.nom_suc;
        document.querySelector('.prinsuc').innerHTML = empresa.prinsuc;
        document.querySelector('.iaeprin').innerHTML = empresa.iaeprin;
        document.querySelector('.grup_act').innerHTML = empresa.grup_act;
        document.querySelector('.f_jur').innerHTML = empresa.f_jur;
        document.querySelector('.nom_muni').innerHTML = empresa.nom_muni;
        document.querySelector('.lat').innerHTML = empresa.lat;
        document.querySelector('.long').innerHTML = empresa.long;
        document.querySelector('.cp').innerHTML = empresa.cp;
}

function fillSinglePoligon(id){
    var myjson = json_infopoligons.features,
        poligon;        

        poligon = myjson.filter(function(emp){
            var check = (emp.properties.id_pol == id) ? true : false;
            return check;
        })

        if(poligon.length == 0){
            document.location = base_url+"poligons/";
        }

        poligon = poligon[0].properties;
        console.log(poligon);
        document.querySelectorAll('.nom_pol').forEach(function(el){ el.innerHTML = poligon.nom_pol; })
        document.querySelector('.nom_mun').innerHTML = poligon.nom_mun;
        document.querySelector('.superf').innerHTML = parseInt(poligon.superf).toFixed(2)+" m2";
        document.querySelector('.any_crea').innerHTML = poligon.any_crea;
        document.querySelector('.sup_edi').innerHTML = poligon.sup_edi+ " m2"
        document.querySelector('.sostre').innerHTML = poligon.sostre+" m2"
        document.querySelector('.tot_ocup').innerHTML = poligon.tot_ocup;
        document.querySelector('.tot_emp').innerHTML = poligon.tot_emp;
        document.querySelector('.tot_ua').innerHTML = poligon.tot_ua;
        document.querySelector('.tot_sol').innerHTML = poligon.tot_sol;
        document.querySelector('.rgrafic').src = base_url_img+'assets/img/poligons/'+poligon.rgrafic;
}

function fillSingleMunicipi(id){
    var myjson = json_infomunicipis.features,
        municipi;        

        municipi = myjson.filter(function(emp){
            var check = (emp.properties.codi_mun == id) ? true : false;
            return check;
        })

        if(municipi.length == 0){
            document.location = base_url;
        }

        municipi = municipi[0].properties;

        document.querySelectorAll('.nom_mun').forEach(function(el){ el.innerHTML = municipi.nom_mun;});
        document.querySelector('.municipi_img').src = base_url_img+'assets/img/municipis/'+municipi.img;
        document.querySelector('.municipi_img').alt = "Escut del l'Ajuntament de "+municipi.nom_mun;
        document.querySelector('.url').innerHTML = municipi.url;
        document.querySelectorAll('.url_src').forEach(function(el){ el.href = municipi.url; })
        document.querySelector('.habitants').innerHTML = municipi.habitants;
        document.querySelector('.tot_pol').innerHTML = municipi.tot_pol;
        document.querySelector('.tot_est').innerHTML = municipi.tot_est;
        document.querySelector('.descrip').innerHTML = municipi.descrip;
}