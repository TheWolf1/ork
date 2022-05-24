function alertaFun(codigo,mensaje){



    switch(codigo){


        case 200:
            toastr.success(mensaje);
            break;
        case 500:
            toastr.error(mensaje);
            break;
    }

    

}