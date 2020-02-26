$(document).ready(function(){
    initSelects();
    switchControls();
    switchMap();
});

var map = L.map('map', {
    zoomControl:true, maxZoom:22, minZoom:8
}).fitBounds([[41.5170890379,2.04740559961],[41.5630085524,2.15434472145]]);
var bounds_group = new L.featureGroup([]);

$(window).on('orientationchange resize', function () {
    resizeMap();
});

function initSelects(){
    var myjson1 = json_empreses.features,
    myjson2 = json_infopoligons.features,
    poligon = uniqueV(myjson2,{name:"nom_pol",id:"id_pol"}),
    activitat = uniqueV(myjson1, {name:"grup_act",id:"idact"});

    fillSelect('select_poligon',poligon,'Tots');
    fillSelect('select_empresa',activitat,'Totes');
}



function resizeMap(){
    map.invalidateSize();
    map.setView([41.7970890379,2.13940559961]);
}

function switchControls(){
    $('.radio-group-principal').find('.button-radio').on('change', function(){
        radioChecked();
    });
    
    radioChecked();

    function radioChecked(){
        var value = $('.radio-group-principal').find('input:checked').val();

        if(value == "InfoImmo"){

            $('.map-menu').find('[data-group="InfoImmo"]').show();
            $('.map-menu').find('[data-group="Poligons"]').hide();

            $("input[name*='checkbox_plaurba']").prop('checked',false);
            $("input[name*='checkbox_empreses']").prop('checked',false);
            $("input[name*='checkbox_solars']").prop('checked',false);
            $("input[name*='checkbox_infopoligons']").prop('checked',false);
            $("input[name*='checkbox_infomunicipis']").prop('checked',false);
            $("input[name*='checkbox_municipis']").prop('checked',false);
            $("input[name*='checkbox_equipaments']").prop('checked',false);
            $("input[name*='checkbox_termemunicipal']").prop('checked',false);
            $("input[name*='checkbox_comarca']").prop('checked',false);
            $("input[name*='checkbox_parcelanaus']").prop('checked',false);
            $("input[name*='checkbox_poligons']").prop('checked',false);
            filters();

        }else if(value == "Poligons"){
            $('.map-menu').find('[data-group="InfoImmo"]').hide();
            $('.map-menu').find('[data-group="Poligons"]').show();

            $("input[name*='checkbox_plaurba']").prop('checked', true);
            $("input[name*='checkbox_empreses']").prop('checked', true);
            $("input[name*='checkbox_solars']").prop('checked', true);
            $("input[name*='checkbox_infopoligons']").prop('checked', true);
            $("input[name*='checkbox_infomunicipis']").prop('checked', true);
            $("input[name*='checkbox_municipis']").prop('checked', true);
            $("input[name*='checkbox_equipaments']").prop('checked', true);
            $("input[name*='checkbox_termemunicipal']").prop('checked', true);
            $("input[name*='checkbox_comarca']").prop('checked', true);
            $("input[name*='checkbox_parcelanaus']").prop('checked', true);
            $("input[name*='checkbox_poligons']").prop('checked', true);
            filters();
            positionMaps();

        }
    }
}

function filters(){
    searchForm({"radio":"immo_01", 
    "range1": "immo_01", 
    "range2": "immo_02", 
    "checkboxes": "infoimmo"});
    sendPlaUrba();    
    sendSolars();
    sendInfoMunicipis();
    sendEquipaments();
    sendParcelaNaus();
    sendPoligons();
    sendTermeMunicipal();
    sendComarca();
    manageInfoPoligons();
    manageEmpreses();
}

function switchMap(){
    var baseLayers = {
        "Satellite": L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',{ attribution: '<a href="https://www.arcgis.com/features/index.html">ArgGIS</a>'}),
        "Street": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: '<a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>'})
    };
    
    var oldLayer = "";

    $("input[name*='map']").on('change',function(){
        if(oldLayer){
            map.removeLayer(baseLayers[oldLayer]);
        }
        var layer = $(this).val();
        map.addLayer(baseLayers[layer]);
        oldLayer = layer;
    });

    map.addLayer(baseLayers["Satellite"]);
    oldLayer = "Satellite";

}

var lyrComarca,
    lyrEquipaments,
    lyrEmpreses,  
    lyrInfoImmo,
    lyrInfoMunicipis, 
    lyrInfoPoligons, 
    lyrMunicipis, 
    lyrParcelaNaus, 
    lyrPlaUrba, 
    lyrPoligons,
    lyrSinglePoligon,
    lyrSolars, 
    lyrTermeMunicipal;


/*
 *   STYLES
 */

function style_equipaments(feature, latlng) {
    var equipIcon = new L.icon({
        iconUrl: base_url_img+'assets/img/legend/mapa/equipaments.png',
        iconSize: [30, 30],
        iconAnchor: [15, 30],
        popupAnchor:  [1, -30],
    });
    return L.marker(latlng, {icon: equipIcon});
}

function style_InfoPoligon(feature, latlng) {
    var inpolIcon = new L.icon({
        iconUrl: base_url_img+'assets/img/legend/mapa/info-poligon.png',
        iconSize: [30, 30],
        iconAnchor: [15, 30],
        popupAnchor:  [1, -30],
    });
    return L.marker(latlng, {icon: inpolIcon});
}


function style_InfoMunicipi(feature, latlng) {
    var inmunIcon = new L.icon({
        iconUrl: base_url_img+'assets/img/legend/mapa/info-municipi.png',
        iconSize: [30, 30],
        iconAnchor: [15, 30],
        popupAnchor:  [1, -30],
    });
    return L.marker(latlng, {icon: inmunIcon});
}


function style_InfoImmo(feature, latlng) {
    
    switch(feature.properties.regim) {
        case 'lloguer':trg
        case 'Lloguer':
            var llogIcon = new L.icon({
                iconUrl: base_url_img+'assets/img/legend/mapa/lloguer.png',
                iconSize: [30, 30],
                iconAnchor: [15, 30],
                popupAnchor:  [1, -30],
            });
            return L.marker(latlng, {icon: llogIcon});
            break;
        break;
        case 'parcel·la':
        case 'Parcel·la':
            var parIcon = new L.icon({
                iconUrl: base_url_img+'assets/img/legend/mapa/parcela.png',
                iconSize: [30, 30],
                iconAnchor: [15, 30],
                popupAnchor:  [1, -30],
            });
            return L.marker(latlng, {icon: parIcon});    
            break;
        case 'compra':
        case 'Compra':
            var venIcon = new L.icon({
                iconUrl: base_url_img+'assets/img/legend/mapa/venda.png',
                iconSize: [30, 30],
                iconAnchor: [15, 30],
                popupAnchor:  [1, -30],
            });    
            return L.marker(latlng, {icon: venIcon});    
        break;
    }
}

 function style_empreses(feature) {
    switch(feature.properties.grup_act) {
        case 'Activitats administratives i serveis auxiliars':
                return {
            pane: 'pane_empreses',
            radius: 8,
            opacity: 1,
            color: 'rgba(83,237,247,1)',
            dashArray: '',
            lineCap: 'butt',
            lineJoin: 'miter',
            weight:0.5,
            fillOpacity: 1,
            fillColor: 'rgba(37,139,146,1)',
        }
        break;
        case 'Activitats financeres i d’assegurances':
            return {
                pane: 'pane_empreses',
                radius: 8,
                opacity: 1,
                color: 'rgba(143,211,237,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight:0.5,
                fillOpacity: 1,
                fillColor: 'rgba(75,185,203,1)',
            }
            break;
        case 'Activitats immobiliàries':
            return {
                pane: 'pane_empreses',
                radius: 8,
                opacity: 1,
                color: 'rgba(247,181,73,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight:0.5,
                fillOpacity: 1,
                fillColor: 'rgba(219,161,66,1)',
            }
            break;
        case 'Activitats professionals, científiques i tècniques':
            return {
                pane: 'pane_empreses',
                radius: 8,
                opacity: 1,
                color: 'rgba(97,243,246,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight:0.5,
                fillOpacity: 1,
                fillColor: 'rgba(83,210,195,1)',
            }
            break;
        case 'Activitats sanitàries i de serveis socials':
            return {
                pane: 'pane_empreses',
                radius: 8,
                opacity: 1,
                color: 'rgba(248,231,28,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight:0.5,
                fillOpacity: 1,
                fillColor: 'rgba(225,209,25,1)',
            }
            break;
        case 'Administració pública, Defensa i Seguretat Social':
            return {
                pane: 'pane_empreses',
                radius: 8,
                opacity: 1,
                color: 'rgba(115,182,255,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight:0.5,
                fillOpacity: 1,
                fillColor: 'rgba(25,121,225,1)',
            }
            break;
        case 'Agricultura, ramaderia, silvicultura i pesca':
            return {
                pane: 'pane_empreses',
                radius: 8,
                opacity: 1,
                color: 'rgba(111,255,45,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight:0.5,
                fillOpacity: 1,
                fillColor: 'rgba(128,237,196,1)',
            }
            break;
        case 'Comerç a l’engròs i al detall; reparació de vehicl':
            return {
                pane: 'pane_empreses',
                radius: 8,
                opacity: 1,
                color: 'rgba(107,176,245,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight:0.5,
                fillOpacity: 1,
                fillColor: 'rgba(93,157,231,1)',
            }
            break;
        case 'Construcció':
            return {
                pane: 'pane_empreses',
                radius: 8,
                opacity: 1,
                color: 'rgba(158,139,252,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight:0.5,
                fillOpacity: 1,
                fillColor: 'rgba(89,74,166,1)',
            }
            break;
        case 'Educació':
            return {
                pane: 'pane_empreses',
                radius: 8,
                opacity: 1,
                color: 'rgba(236,61,61,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight:0.5,
                fillOpacity: 1,
                fillColor: 'rgba(191,29,29,1)',
            }
            break;
        case 'Hostaleria':
            return {
                pane: 'pane_empreses',
                radius: 8,
                opacity: 1,
                color: 'rgba(239,194,26,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight:0.5,
                fillOpacity: 1,
                fillColor: 'rgba(144,119,27,1)',
            }
            break;
        case 'Indústries extractives':
            return {
                pane: 'pane_empreses',
                radius: 8,
                opacity: 1,
                color: 'rgba(172,78,246,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight:0.5,
                fillOpacity: 1,
                fillColor: 'rgba(105,44,153,1)',
            }
            break;
        case 'Indústries manufactureres':
            return {
                pane: 'pane_empreses',
                radius: 8,
                opacity: 1,
                color: 'rgba(79,172,238,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight:0.5,
                fillOpacity: 1,
                fillColor: 'rgba(51,146,218,1)',
            }
            break;
        case 'Informació i comunicacions':
            return {
                pane: 'pane_empreses',
                radius: 8,
                opacity: 1,
                color: 'rgba(255,200,0,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight:0.5,
                fillOpacity: 1,
                fillColor: 'rgba(230,181,3,1)',
            }
            break;
        case 'Subministrament d’aigua; activitats de sanejament,':
            return {
                pane: 'pane_empreses',
                radius: 8,
                opacity: 1,
                color: 'rgba(52,189,248,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight:0.5,
                fillOpacity: 1,
                fillColor: 'rgba(57,121,25,1)',
            }
            break;
        case 'Subministrament d’energia elèctrica, gas, vapor i':
            return {
                pane: 'pane_empreses',
                radius: 8,
                opacity: 1,
                color: 'rgba(99,248,26,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight:0.5,
                fillOpacity: 1,
                fillColor: 'rgba(57,121,25,1)',
            }
            break;
        case 'Transport i emmagatzematge':
            return {
                pane: 'pane_empreses',
                radius: 8,
                opacity: 1,
                color: 'rgba(95,177,252,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight:0.5,
                fillOpacity: 1,
                fillColor: 'rgba(48,110,148,1)',
            }
            break;
        default:
            return {
                pane: 'pane_empreses',
                radius: 8,
                opacity: 1,
                color: 'rgba(195,147,252,1)',
                dashArray: '',
                lineCap: 'butt',
                lineJoin: 'miter',
                weight:0.5,
                fillOpacity: 1,
                fillColor: 'rgba(121,83,166,1)',
            }
            break;
    }
}

/*
* FUNCTIONS
*/

function searchForm(search){

    if($('.radio-group-principal').find('input:checked').val()=="InfoImmo"){
        rangeChange(search);
    };

    sendInfoImmo(search);

    function rangeInit(id,search){
        var recov = search || false, 
            outPutData = new Array();


        if(id=="immo_01"){
            outPutData = {
                "min": 174000.0,
                "max": 337000.0,
                "type": "double",
                "postfix": "€",
                "hide_min_max": true,
                "keyboard": true,
                "step": 10000,
                "grid": true,
                "grid_num": 1,
                "from": 174000.0,
                "from_percent": 25,
                "from_value": null,
                "to": 337000.0,
                "to_percent": 75,
                "to_value": null
            }
        }else{
            outPutData = {
                "min": 350.0,
                "max": 800.0,
                "type": "double",
                "hide_min_max": true,
                "keyboard": true,
                "step": 100,
                "grid": true,
                "grid_num": 1,
                "from": 350.0,
                "from_percent": 25,
                "from_value": null,
                "to": 800.0,
                "to_percent": 75,
                "to_value": null
            }
        }


        $("#range_"+id).ionRangeSlider({
            hide_min_max: outPutData.hide_min_max,
            keyboard: outPutData.keyboard,
            min: outPutData.min,
            max: outPutData.max,
            type: outPutData.type, //double,single
            step: outPutData.step,
            grid: outPutData.grid,
            grid_num: outPutData.grid_num,
            postfix: outPutData.postfix,
            onFinish: function () {
                if(recov){sendInfoImmo(recov)};
            }
        });
    }
    
    function rangeChange(search){
        rangeInit(search.range1, search);
        rangeInit(search.range2, search);

        // var slider1 = $("#range_"+search.range1).data("ionRangeSlider");
        // var slider2 = $("#range_"+search.range2).data("ionRangeSlider");         

        // $("input[name*='radio_"+search.radio+"']").on("change", function(e){

        //     //Lloguer
        //     var outPutData1 = [{
        //         "min": 600,
        //         "max": 10000,
        //         "type": "double",
        //         "postfix": "€",
        //         "hide_min_max": true,
        //         "keyboard": true,
        //         "step": 100,
        //         "grid": true,
        //         "grid_num": 1,
        //         "from": 600,
        //         "from_percent": 25,
        //         "from_value": null,
        //         "to": 10000,
        //         "to_percent": 75,
        //         "to_value": null
        //     },{
        //         "min": 120.0,
        //         "max": 2000.0,
        //         "type": "double",
        //         "hide_min_max": true,
        //         "keyboard": true,
        //         "step": 100,
        //         "grid": true,
        //         "grid_num": 1,
        //         "from": 120.0,
        //         "from_percent": 25,
        //         "from_value": null,
        //         "to": 2000.0,
        //         "to_percent": 75,
        //         "to_value": null
        //     }]
            
        //     //Venda
        //     var outPutData2 = [{
        //         "min": 74000,
        //         "max": 5180000,
        //         "type": "double",
        //         "postfix": "€",
        //         "hide_min_max": true,
        //         "keyboard": true,
        //         "step": 100,
        //         "grid": true,
        //         "grid_num": 1,
        //         "from": 74000,
        //         "from_percent": 25,
        //         "from_value": null,
        //         "to": 5180000,
        //         "to_percent": 75,
        //         "to_value": null
        //     },{
        //         "min": 100.0,
        //         "max": 7000.0,
        //         "type": "double",
        //         "hide_min_max": true,
        //         "keyboard": true,
        //         "step": 100,
        //         "grid": true,
        //         "grid_num": 1,
        //         "from": 100.0,
        //         "from_percent": 25,
        //         "from_value": null,
        //         "to": 7000.0,
        //         "to_percent": 75,
        //         "to_value": null
        //     }];

        //     //Parcel·la
        //     var outPutData3 = [{
        //         "min": 30000,
        //         "max": 600000,
        //         "type": "double",
        //         "postfix": "€",
        //         "hide_min_max": true,
        //         "keyboard": true,
        //         "step": 100,
        //         "grid": true,
        //         "grid_num": 1,
        //         "from": 30000,
        //         "from_percent": 25,
        //         "from_value": null,
        //         "to": 600000,
        //         "to_percent": 75,
        //         "to_value": null
        //     },{
        //         "min": 400.0,
        //         "max": 3200.0,
        //         "type": "double",
        //         "hide_min_max": true,
        //         "keyboard": true,
        //         "step": 100,
        //         "grid": true,
        //         "grid_num": 1,
        //         "from": 400.0,
        //         "from_percent": 25,
        //         "from_value": null,
        //         "to": 3200.0,
        //         "to_percent": 75,
        //         "to_value": null
        //     }];


        //     if($(this).val()=="Lloguer"){
        //         slider1.update(outPutData1[0]);
        //         slider2.update(outPutData1[1]);
        //     }else if($(this).val()=="Venda"){
        //         slider1.update(outPutData2[0]);
        //         slider2.update(outPutData2[1]);
        //     }else{
        //         slider1.update(outPutData3[0]);
        //         slider2.update(outPutData3[1]);   
        //     }

        //     sendInfoImmo(search);
        // })
    }
function sendInfoImmo(search){

        if($('.radio-group-principal').find('input:checked').val()=="InfoImmo"){

            var slider1 = $("#range_"+search.range1).data("ionRangeSlider").result,
            slider2 = $("#range_"+search.range2).data("ionRangeSlider").result;

            if (lyrInfoImmo) {
                map.removeLayer(lyrInfoImmo);
            };


            var myjson = json_infoimmo,
                json_infoimmo_features = myjson.features,
                paneName = 'pane_'+myjson.name;

            
            myjson.features = $(json_infoimmo_features).filter(function (i,myjson){    
                //var tipus_ofer = (myjson.properties.tipus_ofer == radio) ? true : false,
                var preu = (myjson.properties.preu >= slider1.from && myjson.properties.preu <= slider1.to) ? true : false,
                    superficie = (myjson.properties.sup >= slider2.from && myjson.properties.sup <= slider2.to) ? true : false;
                    return preu && superficie; 
            });
            map.createPane(paneName);
            map.getPane(paneName).style.zIndex = 407;
            map.getPane(paneName).style['mix-blend-mode'] = 'normal';
            lyrInfoImmo=L.geoJSON(myjson, {
                pane: paneName,
                onEachFeature: function(feature, layer) {
                    var strPopup = '<div class="modal-info-headline">Oferta Immobiliaria</div>';
                    strPopup += '<ul class="list-2-cols">';
                    strPopup += '<li>Tipus oferta:</li>';
                    strPopup += '<li>'+feature.properties.regim+'</li>';
                    strPopup += '<li>Superfície:</li>';
                    strPopup += '<li>'+feature.properties.sup+'m<sup>2</sup></li>';
                    strPopup += '<li>Poligon:</li>';
                    strPopup += '<li>'+feature.properties.nom_pol+'</li>';
                    strPopup += '<li>Municipi:</li>';
                    strPopup += '<li>'+feature.properties.nom_mun+'</li>';
                    strPopup += '<li>Preu:</li>';
                    strPopup += '<li>'+feature.properties.preu+'€</li>';
                    strPopup += '<li>Telèfon:</li>';
                    strPopup += '<li>'+feature.properties.telef+'</li>';
                    strPopup += '</ul>';
                    strPopup += '<a class="button button-primary" href="'+feature.properties.url+'" target="_blank">Veure Detall</a>';
                    layer.bindPopup(strPopup);

                },
                pointToLayer: style_InfoImmo
            });
            
            lyrInfoImmo.addTo(map);
            bounds_group.addLayer(lyrInfoImmo);

            if(myjson.features.length != 1){
                map.fitBounds(lyrInfoImmo.getBounds());
            }
            
    }else{

        if (lyrInfoImmo) {
            map.removeLayer(lyrInfoImmo);
        };
    }
}}

function sendPlaUrba(){
    if($("input[name*='checkbox_plaurba']").length){
    
        function manageLayer(){
            if($("input[name*='checkbox_plaurba']:checked").length){

                if (lyrPlaUrba) {
                    map.removeLayer(lyrPlaUrba);
                };
        
                var myjson = json_plaurba,
                    paneName = 'pane_'+myjson.name;
        
                map.createPane(paneName);
                map.getPane(paneName).style.zIndex = 408;

                lyrPlaUrba=L.geoJSON(myjson, {
                    pane: paneName,
                    onEachFeature: function(feature, layer) {
        
                        var strPopup = '<div class="modal-info-headline">'+feature.properties.nom_poli+'</div>';
                        strPopup += '<ul class="list-2-cols">';
                        strPopup += '<li>Municipi:</li>';
                        strPopup += '<li>'+feature.properties.nom_muni+'</li>';
                        strPopup += '<li>Superficie:</li>';
                        strPopup += '<li>'+feature.properties.superf+'</li>';
                        strPopup += '<li>Referencia:</li>';
                        strPopup += '<li>'+feature.properties.ref+'m<sup>2</sup></li>';
                        strPopup += '<li>Codi Urbanistic:</li>';
                        strPopup += '<li>'+feature.properties.codi_urb+'</li>';
                        strPopup += '<li>Descripció:</li>';
                        strPopup += '<li>'+feature.properties.descrip+'</li>';
                        strPopup += '</ul>';
                        layer.bindPopup(strPopup);
                    },
                    style: {
                        pane: paneName,
                        opacity: 1,
                        dashArray: '',
                        lineCap: 'butt',
                        lineJoin: 'miter',
                        weight: 1.0, 
                        fillOpacity: 1,
                        fillColor: 'rgba(100,161,225,1)',
                    }
            
                });
                
                lyrPlaUrba.addTo(map);
                bounds_group.addLayer(lyrPlaUrba);
                map.fitBounds(lyrPlaUrba.getBounds());
            }else{
            
                if(lyrPlaUrba) {
                    map.removeLayer(lyrPlaUrba);
                };
            }
        }


        $("input[name*='checkbox_plaurba']").on('click', function(){
            manageLayer();
        })

        manageLayer();
    }
}

function sendSolars(){
    if($("input[name*='checkbox_solars']").length){
    
        function manageLayer(){
            if($("input[name*='checkbox_solars']:checked").length ){

                if (lyrSolars) {
                    map.removeLayer(lyrSolars);
                };
        
                var myjson = json_solars,
                    paneName = 'pane_'+myjson.name;
        
                map.createPane(paneName);
                map.getPane(paneName).style.zIndex = 405;

                lyrSolars=L.geoJSON(myjson, {
                    pane: paneName,
                    onEachFeature: function(feature, layer) {
        
                        var strPopup = '<div class="modal-info-headline">Nau Buida</div>';
                        strPopup += '<ul class="list-2-cols">';
                        strPopup += '<li>Info:</li>';
                        strPopup += '<li>'+feature.properties.info+'</li>';
                        strPopup += '</ul>';
                        layer.bindPopup(strPopup);
                    },
                    style: {
                        pane: paneName,
                        opacity: 1,
                        color: 'rgba(46,225,197,1)',
                        dashArray: '',
                        lineCap: 'butt',
                        lineJoin: 'miter',
                        weight: 1.5, 
                        fillOpacity: 1,
                        fillColor: 'rgba(46,225,197,0.5)'
                    }
            
                });
                
                lyrSolars.addTo(map);
                bounds_group.addLayer(lyrSolars);
                map.fitBounds(lyrSolars.getBounds());
            }else{
            
                if(lyrSolars) {
                    map.removeLayer(lyrSolars);
                };
            }
        }


        $("input[name*='checkbox_solars']").on('click', function(){
            manageLayer();
        })

        manageLayer();
    }
}

function sendSolars(){
    if($("input[name*='checkbox_solars']").length){
    
        function manageLayer(){
            if($("input[name*='checkbox_solars']:checked").length ){

                if (lyrSolars) {
                    map.removeLayer(lyrSolars);
                };
        
                var myjson = json_solars,
                    paneName = 'pane_'+myjson.name;
        
                map.createPane(paneName);
                map.getPane(paneName).style.zIndex = 405;

                lyrSolars=L.geoJSON(myjson, {
                    pane: paneName,
                    onEachFeature: function(feature, layer) {
        
                        var strPopup = '<div class="modal-info-headline">Solar</div>';
                        strPopup += '<ul class="list-2-cols">';
                        strPopup += '<li>Poligon:</li>';
                        strPopup += '<li>'+feature.properties.nom_poli+'</li>';
                        strPopup += '<li>Municipi:</li>';
                        strPopup += '<li>'+feature.properties.nom_muni+'</li>';
                        strPopup += '<li>Info:</li>';
                        strPopup += '<li>'+feature.properties.descrip+'</li>';
                        strPopup += '<li>Refèrencia:</li>';
                        strPopup += '<li>'+feature.properties.ref+'</li>';
                        strPopup += '<li>Codi Urbà:</li>';
                        strPopup += '<li>'+feature.properties.codi_urb+'</li>';
                        strPopup += '</ul>';
                        layer.bindPopup(strPopup);
                    },
                    style: {
                        pane: paneName,
                        opacity: 1,
                        color: 'rgba(46,225,197,1)',
                        dashArray: '',
                        lineCap: 'butt',
                        lineJoin: 'miter',
                        weight: 1.5, 
                        fillOpacity: 1,
                        fillColor: 'rgba(46,225,197,0.5)'
                    }
            
                });
                
                lyrSolars.addTo(map);
                bounds_group.addLayer(lyrSolars);
                map.fitBounds(lyrSolars.getBounds());
            }else{
            
                if(lyrSolars) {
                    map.removeLayer(lyrSolars);
                };
            }
        }


        $("input[name*='checkbox_solars']").on('click', function(){
            manageLayer();
        })

        manageLayer();
    }
}

function sendInfoMunicipis(){
    if($("input[name*='checkbox_infopoligons']").length){
    
        function manageLayer(){
            if($("input[name*='checkbox_infomunicipis']:checked").length ){

                if (lyrInfoMunicipis) {
                    map.removeLayer(lyrInfoMunicipis);
                };
        
                var myjson = json_infomunicipis,
                    paneName = 'pane_'+myjson.name;
        
                map.createPane(paneName);
                map.getPane(paneName).style.zIndex = 404;

                lyrInfoMunicipis=L.geoJSON(myjson, {
                    pane: paneName,
                    onEachFeature: function(feature, layer) {
                        var strPopup = '<div class="modal-info-headline">'+feature.properties.nom_mun+'</div>';
                        strPopup += '<ul class="list-2-cols">';
                        strPopup += '<li>Codi Municipi:</li>';
                        strPopup += '<li>'+feature.properties.codi_mun+'</li>';
                        strPopup += '<li>Habitants:</li>';
                        strPopup += '<li>'+feature.properties.habitants+'</li>';
                        strPopup += '</ul>';
                        strPopup += '<a class="button button-primary" href="'+base_url+'municipis/detall_municipi/'+feature.properties.codi_mun+'">Veure Detall</a>';
                        layer.bindPopup(strPopup);
                    },
                    pointToLayer: style_InfoMunicipi
                });
                
                lyrInfoMunicipis.addTo(map);
                bounds_group.addLayer(lyrInfoMunicipis);
                map.fitBounds(lyrInfoMunicipis.getBounds());
            }else{
            
                if(lyrInfoMunicipis) {
                    map.removeLayer(lyrInfoMunicipis);
                };
            }
        }


        $("input[name*='checkbox_infomunicipis']").on('click', function(){
            manageLayer();
        })

        manageLayer();
    }
}

function sendEquipaments(){
    if($("input[name*='checkbox_equipaments']").length){
    
        function manageLayer(){
            if($("input[name*='checkbox_equipaments']:checked").length ){

                if (lyrEquipaments) {
                    map.removeLayer(lyrEquipaments);
                };
        
                var myjson = json_equipaments,
                    paneName = 'pane_'+myjson.name;
        
                map.createPane(paneName);
                map.getPane(paneName).style.zIndex = 403;

                lyrEquipaments=L.geoJSON(myjson, {
                    pane: paneName,
                    onEachFeature: function(feature, layer) {
                        var strPopup = '<div class="modal-info-headline">'+feature.properties.nom_equip+'</div>';
                        strPopup += '<ul class="list-2-cols">';
                        strPopup += '<li>Adreça:</li>';
                        strPopup += '<li>'+feature.properties.adreca+'</li>';
                        strPopup += '<li>Municipi:</li>';
                        strPopup += '<li>'+feature.properties.nom_mun+'</li>';
                        if(feature.properties.telefon != null){
                            strPopup += '<li>Telèfon:</li>';
                            strPopup += '<li>'+feature.properties.telefon+'</li>';
                        }
                        strPopup += '</ul>';
                        if(feature.properties.url != null){
                            strPopup += '<a class="button button-primary" href="'+feature.properties.url+'" target="_blank">Info</a>';
                        };
                        layer.bindPopup(strPopup);
                    },
                    pointToLayer: style_equipaments
                });
                
                lyrEquipaments.addTo(map);
                bounds_group.addLayer(lyrEquipaments);
                map.fitBounds(lyrEquipaments.getBounds());
            }else{
            
                if(lyrEquipaments) {
                    map.removeLayer(lyrEquipaments);
                };
            }
        }


        $("input[name*='checkbox_equipaments']").on('click', function(){
            manageLayer();
        })

        manageLayer();
    }
}

function sendParcelaNaus(){
    if($("input[name*='checkbox_parcelanaus']").length){
    
        function manageLayer(){
            if($("input[name*='checkbox_parcelanaus']:checked").length ){

                if (lyrParcelaNaus) {
                    map.removeLayer(lyrParcelaNaus);
                };
        
                var myjson = json_parcelanaus,
                    paneName = 'pane_'+myjson.name;
        
                map.createPane(paneName);
                map.getPane(paneName).style.zIndex = 302;

                lyrParcelaNaus=L.geoJSON(myjson, {
                    pane: paneName,
                    style: {
                        pane: paneName,
                        opacity: 1,
                        color: 'rgba(225,67,46,1)',
                        dashArray: '',
                        lineCap: 'butt',
                        lineJoin: 'miter',
                        weight: 1.5, 
                        fillOpacity: 1,
                        fillColor: 'rgba(225,67,46,0.0)'
                    }
            
                });
                
                lyrParcelaNaus.addTo(map);
                bounds_group.addLayer(lyrParcelaNaus);
                map.fitBounds(lyrParcelaNaus.getBounds());
            }else{
            
                if(lyrParcelaNaus) {
                    map.removeLayer(lyrParcelaNaus);
                };
            }
        }


        $("input[name*='checkbox_parcelanaus']").on('click', function(){
            manageLayer();
        })

        manageLayer();
    }
}

function sendTermeMunicipal(){
    if($("input[name*='checkbox_termemunicipal']").length){
    
        function manageLayer(){
            if($("input[name*='checkbox_termemunicipal']:checked").length ){

                if (lyrTermeMunicipal) {
                    map.removeLayer(lyrTermeMunicipal);
                };
        
                var myjson = json_termemunicipal,
                    paneName = 'pane_'+myjson.name;
        
                map.createPane(paneName);
                map.getPane(paneName).style.zIndex = 301;

                lyrTermeMunicipal=L.geoJSON(myjson, {
                    pane: paneName,
                    style: {
                        pane: paneName,
                        opacity: 1,
                        color: 'rgba(227,45,116,0.69)',
                        dashArray: '',
                        lineCap: 'butt',
                        lineJoin: 'miter',
                        weight: 3, 
                        fillOpacity: 1,
                        fillColor: 'rgba(227,45,116,0)'
                    }
            
                });
                
                lyrTermeMunicipal.addTo(map);
                bounds_group.addLayer(lyrTermeMunicipal);
                map.fitBounds(lyrTermeMunicipal.getBounds());
            }else{
            
                if(lyrTermeMunicipal) {
                    map.removeLayer(lyrTermeMunicipal);
                };
            }
        }


        $("input[name*='checkbox_termemunicipal']").on('click', function(){
            manageLayer();
        })

        manageLayer();
    }
}

function sendComarca(){
    if($("input[name*='checkbox_comarca']").length){
    
        function manageLayer(){
            if($("input[name*='checkbox_comarca']:checked").length ){

                if (lyrComarca) {
                    map.removeLayer(lyrComarca);
                };
        
                var myjson = json_comarca,
                    paneName = 'pane_'+myjson.name;
        
                map.createPane(paneName);
                map.getPane(paneName).style.zIndex = 301;

                lyrComarca=L.geoJSON(myjson, {
                    pane: paneName,
                    style: {
                        pane: paneName,
                        opacity: 1,
                        color: 'rgba(0,20,20,0.49)',
                        dashArray: '',
                        lineCap: 'butt',
                        lineJoin: 'miter',
                        weight: 3, 
                        fillOpacity: 1,
                        fillColor: 'rgba(227,45,116,0)'
                    }
            
                });
                
                lyrComarca.addTo(map);
                bounds_group.addLayer(lyrComarca);
                map.fitBounds(lyrComarca.getBounds());
            }else{
            
                if(lyrComarca) {
                    map.removeLayer(lyrComarca);
                };
            }
        }


        $("input[name*='checkbox_comarca']").on('click', function(){
            manageLayer();
        })

        manageLayer();
    }
}


// function sendDetall(){
//     if($(".detall-map").length){
    
//         var myjson = json_detallmap,
//             paneName = 'pane_'+myjson.name;

//         map.createPane(paneName);
//         map.getPane(paneName).style.zIndex = 402;

//         lyrSinglePoligon=L.geoJSON(myjson, {
//             pane: paneName,
//             style: {
//                 pane: paneName,
//                 opacity: 1,
//                 color: 'rgba(198,2,54,1.0)',
//                 dashArray: '',
//                 lineCap: 'butt',
//                 lineJoin: 'miter',
//                 weight: 1.0, 
//                 fillOpacity: 1,
//                 fillColor: 'rgba(176,168,53,1.0)'
//             }
    
//         });
        
//         lyrSinglePoligon.addTo(map);
//         bounds_group.addLayer(lyrSinglePoligon);
//         map.fitBounds(lyrSinglePoligon.getBounds());
//         map.setZoom(17);
//     }
// }


function sendPoligons(){
    if($("input[name*='checkbox_poligons']").length){
    
        function manageLayer(){
            if($("input[name*='checkbox_poligons']:checked").length ){

                $(".poligons-ctrls").slideDown(300);

                if (lyrPoligons) {
                    map.removeLayer(lyrPoligons);
                };
        
                var myjson = json_poligons,
                    paneName = 'pane_'+myjson.name;

                map.createPane(paneName);
                map.getPane(paneName).style.zIndex = 300;

                lyrPoligons=L.geoJSON(myjson, {
                    pane: paneName,
                    style: {
                        pane: paneName,
                        opacity: 1,
                        color: 'rgba(170,237,98,1)',
                        dashArray: '',
                        lineCap: 'butt',
                        lineJoin: 'miter',
                        weight: 1.5, 
                        fillOpacity: 1,
                        fillColor: 'rgba(170,237,98,0)'
                    }
                });
                
                lyrPoligons.addTo(map);
                bounds_group.addLayer(lyrPoligons);
                map.fitBounds(lyrPoligons.getBounds());
 
            }else{

                if(lyrPoligons) {
                    map.removeLayer(lyrPoligons);
                };
            }
        }


        $("input[name*='checkbox_poligons']").on('click', function(){
            $('#select_poligon').val('0');
            $('#select_styled_select_poligon').text($("#select_poligon option:first").text()).removeClass('active');
            manageLayer();
        })

        manageLayer();
    }
}

function manageInfoPoligons(){
    
    $('#select_poligon').on('select2:select', function (e) {
        var val = e.params.data.id;
        sendInfoPoligons(val);
    });

    sendInfoPoligons(0);
}

function sendInfoPoligons(poligon){
    if($("input[name*='checkbox_infopoligons']").length){
    
        function manageLayer(){
            if($("input[name*='checkbox_infopoligons']:checked").length ){

                if (lyrInfoPoligons) {
                    map.removeLayer(lyrInfoPoligons);
                };
                
                //Clonem el Json porque si no apunta al mateix lloc i a la segona vegada ja no hi ha features
                var myjson = JSON.parse(JSON.stringify(json_infopoligons)),
                    myjson_features = myjson.features,
                    paneName = 'pane_'+myjson.name;


                if(parseInt(poligon)!==0){
                    myjson.features = myjson_features.filter(function (item){
                        
                        var check = (item.properties.id_pol == poligon) ? true : false;
        
                        return check; 
                    });
                }

                map.createPane(paneName);
                map.getPane(paneName).style.zIndex = 404;

                lyrInfoPoligons=L.geoJSON(myjson, {
                    pane: paneName,
                    onEachFeature: function(feature, layer) {
                        var strPopup = '<div class="modal-info-headline">'+feature.properties.nom_pol+'</div>';
                        strPopup += '<ul class="list-2-cols">';
                        strPopup += '<li>Minicípi:</li>';
                        strPopup += '<li>'+feature.properties.nom_mun+'</li>';
                        strPopup += '<li>Superficie:</li>';
                        strPopup += '<li>'+feature.properties.superf+'m<sup>2</sup></li>';
                        strPopup += '<li>Superficie Edificada:</li>';
                        strPopup += '<li>'+feature.properties.sup_edi+'m<sup>2</sup></li>';
                        strPopup += '<li>Nº Empreses:</li>';
                        strPopup += '<li>'+feature.properties.tot_emp+'</li>';
                        strPopup += '<li>Nº UA:</li>';
                        strPopup += '<li>'+feature.properties.tot_ua+'</li>';
                        strPopup += '<li>Nº Solars:</li>';
                        strPopup += '<li>'+feature.properties.tot_sol+'</li>';
                        strPopup += '</ul>';
                        strPopup += '<a class="button button-primary" href="'+base_url+'poligons/detall_poligon/'+feature.properties.id_pol+'">Veure Detall</a>';

                        layer.bindPopup(strPopup);
                    },
                    pointToLayer: style_InfoPoligon
                });

                lyrInfoPoligons.addTo(map);
                bounds_group.addLayer(lyrInfoPoligons);
                map.fitBounds(lyrInfoPoligons.getBounds());
                if(parseInt(poligon)!==0){
                    map.setZoom(16);
                }
            }else{
            
                if(lyrInfoPoligons) {
                    map.removeLayer(lyrInfoPoligons);
                };
            }
        }


        $("input[name*='checkbox_infopoligons']").on('click', function(){
            manageLayer();
        })

        manageLayer();
    }
}

function manageEmpreses(){    
    initialize();
    selectTypeEmpresa(json_empreses.features);
    customSearch("livesearch-empreses", json_empreses.features);
    sendEmpreses(json_empreses.features, "");

    $("input[name*='checkbox_empreses']").on('click', function(){
        initialize();
        sendEmpreses(json_empreses.features, "");
    })

    function initialize(){
        $('#livesearch-empreses-input').text('');
        $('#livesearch-empreses-input').val('');
        $('#livesearch-empreses-result').html('');
        $("#select_empresa").val("0");
    }
}

function customSearch(name, myJson){
    var input = '#'+name+'-input',
        result = '#'+name+'-result';

    $(input).keyup(function(){

        if($(input).val()==""){
            switch(name){
                case "livesearch-empreses":
                    var myjson = lifeSearchEmpresa(myJson, "");
                    sendEmpreses(myjson, "");
                break;
            }
        }else{
           
            $(result).html('');
            var searchField = $(input).val(),
                expression = new RegExp(searchField, "i"),
                total = 0;
            
                switch(name){
                    case "livesearch-empreses":
                        var myjson = lifeSearchEmpresa(myJson, expression);
                    break;
                }
            
    
            $(myjson).each(function (i,myjson){
                switch(name){
                    case "livesearch-empreses":
                        var value = myjson.properties.nom_comr;
                    break;
                }
                
                $(result).append('<li class="search-correct">'+value+'</li>');
                total++;
            });
    
            if(total==0){
                $(result).append('<li class="search-no-correct">No em trobat res</li>'); 
            }
        }
        

        $(result).find('.search-correct').on('click', function() {
            var click_text = $(this).text();
            $(input).val(click_text);
            $(result).html('');
            switch(name){
                case "livesearch-empreses":
                    sendEmpreses(myjson, click_text);
                    break;
            }
        });   

   });

   function lifeSearchEmpresa(myJson, expression){
        return $(myJson).filter(function (i,myjson){
            var check = (myjson.properties.nom_comr.search(expression) != -1) ? true : false;
            if($('#select_empresa option:selected').val()!=0){
                var check2 = (myjson.properties.grup_act == $('#select_empresa option:selected').text());
                return check && check2; 
            }else{
                return check;
            }
        });
   }
}

function selectTypeEmpresa(myjson_features){
    if($("input[name*='checkbox_empreses']:checked").length){
        
        $('#select_empresa').on('change', function(){
            var value = $('#select_empresa option:selected').val(),
                text = $('#select_empresa option:selected').text();
            
            
            if(value!=0){
                var myjson_reduced = $(myjson_features).filter(function (i,myjson){

                    if (myjson.properties.grup_act == text){ 
                        return true; 
                    }
                });
            }else{
                var myjson_reduced = myjson_features;
            }

            sendEmpreses(myjson_reduced, "");
            $('#livesearch-empreses-input').text('');
            $('#livesearch-empreses-input').val('');
            $('#livesearch-empreses-result').html('');
        });
    };
}

function sendEmpreses(myjson_features, empresa){
    
        function manageLayer(){
            if($("input[name*='checkbox_empreses']:checked").length ){

                if (lyrEmpreses) {
                    map.removeLayer(lyrEmpreses);
                };
        
                var myjson = json_empreses,
                    paneName = 'pane_'+myjson.name;
                
                if(empresa !=""){            
                    myjson.features = $(myjson_features).filter(function (i,myJson){
                                        var check = (myJson.properties.nom_comr ==  empresa) ? true : false;
                                        return check;
                                    });
                }else{
                    myjson.features = myjson_features;
                }
                map.createPane(paneName);
                map.getPane(paneName).style.zIndex = 516;

                lyrEmpreses=L.geoJSON(myjson, {
                    pane: paneName,
                    onEachFeature: function(feature, layer) {
                        var strPopup = '<div class="modal-info-headline">'+feature.properties.nom_comr+'</div>';
                        strPopup += '<ul class="list-2-cols">';
                        strPopup += '<li>Adreça:</li>';
                        strPopup += '<li>'+feature.properties.adreca+'</li>';
                        strPopup += '<li>Grup Activitat:</li>';
                        strPopup += '<li>'+feature.properties.grup_act+'</sup></li>';
                        strPopup += '<li>Activitat:</li>';
                        strPopup += '<li>'+feature.properties.actvitat_p+'</li>';
                        strPopup += '<li>Nº Empleats:</li>';
                        strPopup += '<li>'+feature.properties.empleats+'</li>';
                        strPopup += '<li>Facturació:</li>';
                        strPopup += '<li>'+feature.properties.facturacio+'</li>';
                        strPopup += '<li>Telefon:</li>';
                        strPopup += '<li>'+feature.properties.telf_f+'</li>';
                        strPopup += '<li>Web:</li>';
                        strPopup += '<li>'+feature.properties.url+'</li>';
                        strPopup += '</ul>';
                        strPopup += '<a class="button button-primary" href="'+base_url+'empreses/detall_empresa/'+feature.properties.id_emp+'">Veure Detall</a>'
                        layer.bindPopup(strPopup);
                    },
                    pointToLayer: function (feature, latlng) {
                        return L.circleMarker(latlng, style_empreses(feature));
                    },
                    
                    //pointToLayer: style_empreses
                });
                
                lyrEmpreses.addTo(map);
                bounds_group.addLayer(lyrEmpreses);
                map.fitBounds(lyrEmpreses.getBounds());
                if(empresa !="" || myjson.features.length<=4){     
                    map.setZoom(15);
                }
            }else{
            
                if(lyrEmpreses) {
                    map.removeLayer(lyrEmpreses);
                };
            }
        }

        manageLayer();
}

