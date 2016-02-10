app.controller('custController', function($scope,Api){

    Api.query({
        method:'get-customers'
    },function(data){
        $scope.customers = data
    });
    
    /*	 var cache = $cacheFactory('Api');
	 console.log(cache);*/
	
    $scope.custClick = function(id) {
        window.location = '#/profile/'+id;
    }

});

app.controller('orderController', function($scope, Api){

    Api.query({
        method:'get-orders'
    },function(data){
        $scope.orders = data;
    });

});

app.controller('orderChildController',function($scope){

    if($scope.order && $scope.order.orders){
		
        var total = 0.00;
        for(var i = 0; i < $scope.order.orders.length; i++){
            $scope.order.orders[i].total = $scope.order.orders[i].quantity * $scope.order.orders[i].price;
            total += $scope.order.orders[i].total;
        }
        $scope.total = total;

    }
});

app.controller('productController', function($scope, Api){

    Api.query({
        method:'get-products'
    },function(data){
        $scope.products = data;
    });


});

app.controller('profileController', function($scope, $routeParams, Api){
    Api.get({
        method:'get-orders',
        id:$routeParams.id
    },function(data){
        $scope.profile = data;
        var total = 0.00;
        for(var i = 0; i < $scope.profile.orders.length; i++){
            $scope.profile.orders[i].total = $scope.profile.orders[i].quantity * $scope.profile.orders[i].price;
            total += $scope.profile.orders[i].total;
        }
        $scope.total = total;
    });
});

app.controller('actionController', function($scope, $routeParams, $location, Api){

    var actions = ['add','update','delete'];
    var page =  $routeParams.page;
    page = page.substr(0,1).toUpperCase() + page.substr(1);
    var action = $routeParams.action;
    action = action.substr(0,1).toUpperCase() + action.substr(1);
	
    $scope.is_disabled = $routeParams.action == 'delete' ? true : false;
    $scope.page = page;
    $scope.action = action;

    if(actions.indexOf($routeParams.action) == -1){
        $location.path('/customers');
    }
    // route page
    $scope.templateUrl = function() {
        return '/angular-js-crud-template/add-' + $routeParams.page;
    }

    $scope.cancel = function() {
        $location.path('/customers');
    }

    $scope.delete = function() {
        var id = $routeParams.id;
        Api.delete({
            method:'delete',
            id:id,
            param:$routeParams.page
        },function(result){
            if(result.$resolved == true){
                $location.path('/' + $routeParams.page + 's');
            }
        });
    }

    if($routeParams.action != 'add' && $routeParams.id) {
        var method = 'get-'+ $routeParams.page + 's';
        Api.get({
            method:method,
            id:$routeParams.id
        }, function(data){
            if($routeParams.page == 'customer'){
                $scope.first_name = data.first_name;
                $scope.last_name = data.last_name;
                $scope.email = data.email;
                $scope.contact_no = data.contact_no;
                $scope.address = data.address;
            }else if($routeParams.page == 'product'){
                $scope.product = data.product;
                $scope.price = data.price;
            }
			
        });

    }

});

app.controller('actionCustController', function($scope, $routeParams, Api) {
    var data = {};
    data.action = $routeParams.action;
    data.page = $routeParams.page;
    $scope.save = function() {
        data.first_name = $scope.first_name;
        data.last_name = $scope.last_name;
        data.address = $scope.address;
        data.email = $scope.email;
        data.contact_no = $scope.contact_no;
        //var isValid = $scope.custForm.$valid;
        var formValid = $('form').simpleForm();

        if(formValid)
            save(Api,data,$routeParams.id);
    }

});

app.controller('actionOrderController', function($scope, $routeParams, Api, myService) {

    Api.query({
        method:'get-customers'
    },function(data){
        $scope.customers = data;
    });
    Api.query({
        method:'get-products'
    },function(data){
        $scope.products = data;
    });
	
    $scope.save = function() {

        var formValid = $('form').simpleForm();
        var data = {};
        data.cust_id = $scope.cust_id.id
        data.product_id = $scope.product_id.id
        data.quantity = $scope.quantity;
        data.action = $routeParams.action;
        data.page = $routeParams.page;
        var isValid = $scope.orderForm.$valid;

        if(formValid)
            save(Api,data,$routeParams.id);
    }

    window.scope = $scope; // debug for chrome browser
});

app.controller('actionProductController', function($scope, $routeParams, Api) {

    $scope.save = function() {
        var formValid = $('form').simpleForm();
        var data = {};
        data.product = $scope.product;
        data.price = $scope.price;
        data.action = $routeParams.action;
        data.page = $routeParams.page;
        var isValid = $scope.productForm.$valid;

        if(formValid)
            save(Api,data,$routeParams.id);
    }



});

app.controller('navController',function($scope,$location){

    // make active the selected menu
    $scope.getClass = function (path) {
        var sub = path.substr(0,1);
        if(path.indexOf(',') != -1){
            var addMenus  = path.split(',')
            for(var i = 0; i <= addMenus.length -1; i++){
                if(addMenus[i] == $location.path().substr(0, path.length))
                    return true;
            }
	 		
        }else{
            if ($location.path().substr(0, path.length) == path) {
                return true
            } else {
                return false;
            } 
        }
        
        $scope.toggle_open = function() {
            
            if(!$('.target_dropdown').hasClass('open')){
                $('.target_dropdown').addClass('open');
            }
            
        }
    }
});

function save(Api, data, id) {
    if(data.action == 'add'){
        Api.save({
            method:'save'
        },data,function(result){
            if(result.$resolved == true) 
                if(data.page == 'order'){
                    window.location = '#/profile/'+data.cust_id;
                }else{
                    window.location = '#/'+ data.page + 's';
                }
            
        });
    }else if(data.action == 'update'){
        Api.update({
            method:'save',
            id:id
        },data,function(result){
            if(result.$resolved == true) 
                window.location = '#/'+ data.page + 's';
        });
    }
}