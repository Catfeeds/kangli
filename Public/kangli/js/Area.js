
function initComplexArea(a, k, h, p, q, s, d, b, l) {
    var f = initComplexArea.arguments;
    var m = document.getElementById(a);//seachprov
    var o = document.getElementById(k);//seachcity
    var n = document.getElementById(h);//seachdistrict
    var e = 0;
    var c = 0;
	
    if (p != undefined) {
        if (d != undefined) {
            d = parseInt(d);  //prov
        }
        else {
            d = 0;
        }
        if (b != undefined) {
            b = parseInt(b); //city
        }
        else {
            b = 0;
        }
        if (l != undefined) {
            l = parseInt(l);  //district
        }
        else {
            l = 0;
        }

        for (e = 0; e < p.length; e++) {  //provlist  p-area_array
            if (p[e] == undefined) {
                continue;
            }
            m[c] = new Option(p[e], e);
            if (d == e) {
                m[c].selected = true;
            }
            c++;
        }
        if (q[d] != undefined) {   //citylist  sub_array
            c = 0;
			for (e = 0; e < q[d].length; e++) {
                if (q[d][e] == undefined) { continue }
				o[c] = new Option(q[d][e], e);
                if (b == e) { o[c].selected = true ;}
				c++;
            }
        }
		
		if (s[b] != undefined) {   //districtlist  sub_arr
            c = 0;
			for (e = 0; e < s[b].length; e++) {
                if (s[b][e] == undefined) { continue }
                n[c] = new Option(s[b][e], e);
                if (l == e) { n[c].selected = true }
				c++;
            }
        }
		if (d == 11 || d == 12 || d == 31 || d == 71 || d == 50 || d == 81 || d == 82) {
            if ($("#" + h + "_div"))
            { $("#" + h + "_div").hide(); }
        }
			
    }
}
function changeComplexProvince(f, k, e, d) {
    var c = changeComplexProvince.arguments;
	var h = document.getElementById(e);//seachcity
    var g = document.getElementById(d);//seachdistrict
	var b = 0; var a = 0; removeOptions(h); f = parseInt(f);
    if (k[f] != undefined) {
        for (b = 0; b < k[f].length; b++) {
            if (k[f][b] == undefined) { continue }
            if (c[3]) { if ((c[3] == true) && (f != 71) && (f != 81) && (f != 82)) { if ((b % 100) == 0) { continue } } }
            h[a] = new Option(k[f][b], b); a++
        }
    }
    if(f==0){removeOptions(h); h[0] = new Option("请选择 ", 0);}
	removeOptions(g); g[0] = new Option("请选择 ", 0);
    if (f == 11 || f == 12 || f == 31 || f == 71 || f == 50 || f == 81 || f == 82) {
        if ($("#" + d + "_div"))
        { $("#" + d + "_div").hide(); }
    }
    else {
        if ($("#" + d + "_div")) { $("#" + d + "_div").show(); }
    }
}

 
function changeCity(c, a, t) {
    $("#" + a).html('<option value="0" >请选择</option>');
    $("#" + a).unbind("change");
    c = parseInt(c); 

    var _d = sub_arr[c];
    var str = "";   
	str += "<option value='0' >请选择</option>";
	if(_d != undefined){
    for (var i = c * 100; i < _d.length; i++) {
        if (_d[i] == undefined) continue; 
        str += "<option value='" + i + "' >" + _d[i] + "</option>";
    }
	}
    $("#" + a).html(str);
    
}

function removeOptions(c) {
    if ((c != undefined) && (c.options != undefined)) {
        var a = c.options.length;
        for (var b = 0; b < a; b++) {
            c.options[0] = null;
        }
    }
}
