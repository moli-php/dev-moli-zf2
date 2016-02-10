var api = {
	
    base_url : document.getElementById('order_entry_base_url').innerHTML,
    site_url : document.getElementById('order_entry_site_url').innerHTML,

    addCustomer : function(data) {
        var result = false;
        $.ajax({
            url : api.base_url +'/add-customer',
            type : 'post',
            data : data,
            async : false,
            dataType : 'json',
            success : function(data){
                result = data;
            }
        });
        return result;
	
    },

    deleteCustomer : function(data) {
        var result = false;

        $.ajax({
            url : api.base_url +'/delete-customer',
            type : 'delete',
            data : data,
            async : false,
            success : function(data){
                result = data;
            }
        });
		
        return result;
    },

    updateCustomer : function(id, data) {
        var result = false;
        $.ajax({
            url : api.base_url +'/update-customer/'+id,
            type : 'put',
            data : data,
            async : false,
            success : function(data){
                result = data;
            }
        });
		
        return result;
    },

    addProduct : function(data) {
        var result = false;
        $.ajax({
            url : api.base_url +'/add-product',
            type : 'post',
            data : data,
            async : false,
            success : function(data){
                result = data;
            }
        });
		
        return result;
	
    },

    deleteProduct : function(data) {
        var result = false;
        $.ajax({
            url : api.base_url +'/delete-product',
            type : 'delete',
            data : data,
            async : false,
            success : function(data){
                result = data;
            }
        });
		
        return result;
    },

    updateProduct : function(id, data) {
        var result = false;
        $.ajax({
            url : api.base_url +'/update-product/'+id,
            type : 'put',
            data : data,
            async : false,
            success : function(data){
                result = data;
            }
        });
		
        return result;
    },

    addPurchase : function(data) {
        var result = false;
        $.ajax({
            url : api.base_url +'/add-purchase',
            type : 'post',
            data : data,
            async : false,
            success : function(data){
                result = data;
            }
        });
		
        return result;
    },

    updatePurchase : function(id, data) {
        var result = false;
        
        $.ajax({
            url : api.base_url +'/update-purchase/'+id,
            type : 'put',
            data : data,
            async : false,
            success : function(data){
                result = data;
            }
        });
		
        return result;
    },

    addPayment : function(data) {
        var result = false;
        $.ajax({
            url : api.base_url +'/add-payment',
            type : 'post',
            data : data,
            async : false,
            success : function(data){
                result = data;
            }
        });
		
        return result;
    },

    updatePayment : function(id, data) {
        var result = false;
        $.ajax({
            url : api.base_url +'/update-payment/'+id,
            type : 'put',
            data : data,
            async : false,
            success : function(data){
                result = data;
            }
        });
		
        return result;
    }

}