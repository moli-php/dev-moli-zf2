var App = {
    Model : {},
    Collection : {},
    View : {},
    Route : {}
};
//Backbone.emulateHTTP = true;
//Backbone.emulateJSON = true;

App.Model.Forum = Backbone.Model.extend({
    defaults : {
        id : '',
        name : '',
        username : '',
        user_id : '',
        message : '',
        replies : '',
        date : ''
    },
    urlRoot : '/backbone-js-blog-api/api'
});

App.Model.RouteModel = Backbone.Model.extend({
    defaults : {
        page : 0,
        thread_id : 0,
        thread_page : 0
    }
});

App.Model.PaginatorModel = Backbone.Model.extend({
    defaults : {
        per_page : 5,
        length : 5,
        start : 1,
        end : 5
    }
});

var routeModel = new App.Model.RouteModel();

App.Route.Forum = Backbone.Router.extend({
    initialize : function() {
        Backbone.history.start();
    },
    
    routes :  {
        '' : 'index',
        ':page' : 'getPage',
        ':page/thread/:thread_id(/:thread_page)' : 'getThread'
    },
    
    index : function() {
        routeModel.set('page', 1);
        routeModel.set({
            'thread_id': 0, 
            'thread_page' : 0
        },{
            silent:true
        });
    },
    
    getPage : function(page) {
        routeModel.set('page', page);
        routeModel.set({
            'thread_id': 0, 
            'thread_page' : 0
        },{
            silent:true
        });
    },
    
    getThread : function(page, thread_id, thread_page) {
        thread_page = thread_page ? thread_page :  1;
        routeModel.set({
            'page':page, 
            'thread_id':thread_id, 
            'thread_page':thread_page
        });
    }
  
})

var routeForum = new App.Route.Forum();

function formatDate(data) {
    if(data) {
        data = data.split(" ");
        var date = data[0];
        var time = data[1].split(":");
        var hours = time[0];
        var minutes = time[1];
        var ampm = hours > 12 ? 'pm' : 'am';
        hours = hours > 12 ? hours - 12 : (hours == 0 ? 12 : hours);
        //        minutes = minutes < 10 ? '0' + minutes : minutes;
        return date + ' at ' + hours + ':' + minutes + ' ' + ampm;
    }else{
        var d = new Date();
        var hours = d.getHours() < 10 ? '0' + d.getHours() : d.getHours();
        var minutes = d.getMinutes() < 10 ? '0' + d.getMinutes() : d.getMinutes();
        var seconds = d.getSeconds() < 10 ? '0' + d.getSeconds() : d.getSeconds();
        var day = d.getDate() < 10 ? '0' + d.getDate() : d.getDate();
        var month = d.getMonth() + 1;
        month = month < 10 ? '0' + month : month;
        var year = d.getFullYear();
        return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
    }
}


App.Collection.Forum = Backbone.Collection.extend({
    model : App.Model.Forum,
    url : '/backbone-js-blog-api/api'
});

App.Model.Reply = Backbone.Model.extend({
    defaults : {
        date : '',
        formatDate : '',
        forum_id : '',
        id : '',
        message : '',
        name : '',
        user_id : '',
        username : ''
    },
    urlRoot : '/backbone-js-blog-api/reply-api'
    
})

App.Collection.Replies = Backbone.Collection.extend({
    model : App.Model.Reply,
    url : '/backbone-js-blog-api/reply-api'
})

App.View.Paginator = Backbone.View.extend({
    
    initialize : function(opts) {
        this.routeModel = opts.routeModel;
        this.paginatorModel = opts.paginatorModel;
        this.listenTo(this.routeModel, 'change:page', this.render);
        this.listenTo(this.collection, 'reset', this.render);
        this.listenTo(this.collection, 'remove', this.render);
        this.render();
    },
    
    template : _.template($('#paginator_template').html()),
    
    render : function() {
        var total_page = Math.ceil(this.collection.length / this.paginatorModel.get('per_page'));
        var current_page = this.routeModel.get('page');
        var pagination_length = this.paginatorModel.get('length')
        var previous = false;
        var next = false;
        if(total_page > pagination_length){
            previous = current_page <= pagination_length ? false : true;
            var start_page = current_page % pagination_length != 0
            ? current_page - (current_page % pagination_length) + 1
            : current_page - (pagination_length - 1);
            var end_page = start_page + (pagination_length - 1);
            
            if(total_page > start_page){
                this.paginatorModel.set('start', start_page);
            }else{
                this.paginatorModel.set('start', total_page);
            }
            
            if(total_page > end_page){
                this.paginatorModel.set('end', end_page);
                next = true;
            }else{
                this.paginatorModel.set('end', total_page);
                next = false;
            }
           
        }else{
            previous = false;
            next = false;
            this.paginatorModel.set('start', 1);
            this.paginatorModel.set('end', total_page);
        }
        
        if(this.collection.length){
            var start = this.paginatorModel.get('start');
            var end = this.paginatorModel.get('end');
            this.$el.html("");
            
            for(var i = start; i <= end; i++){
                
                var is_active = (i == current_page) ? 'class="active"' : '';
                var enable_previous = (start == i) ? true : false;
                var enable_next = (end == i) ? true : false;
                
                var template = this.template({
                    is_active : is_active,
                    page : i,
                    previous : previous,
                    next : next,
                    start : start - 1,
                    end : end + 1,
                    enable_previous : enable_previous,
                    enable_next : enable_next
                });
                this.$el.append(template);
            }
        }else{
            this.$el.html("");
        }
    }
});

App.View.Paginator.Replies = Backbone.View.extend({
    
    initialize : function(opts) {
        this.model = opts.model;
        this.routeModel = opts.routeModel;
        this.paginatorModel = opts.paginatorModel;
        this.repliesCollection = opts.repliesCollection
        this.listenTo(this.routeModel, 'change:thread_page', this.render);
        this.listenTo(this.repliesCollection, 'all', this.render);
        this.render();
        
    },
    
    template : _.template($('#paginator_replies_template').html()),
    
    render : function() {
   
        if(this.model.get('id') != this.routeModel.get('thread_id'))
            return false;
        
        var total_page = Math.ceil(this.repliesCollection.length / this.paginatorModel.get('per_page'));
        
        var current_page = this.routeModel.get('thread_page');
        var thread_id = this.routeModel.get('thread_id');
        var pagination_length = this.paginatorModel.get('length')
        var previous = false;
        var next = false;
        if(total_page > pagination_length){
            previous = current_page <= pagination_length ? false : true;
            var start_page = current_page % pagination_length != 0
            ? current_page - (current_page % pagination_length) + 1
            : current_page - (pagination_length - 1);
            var end_page = start_page + (pagination_length - 1);
            
            if(total_page > start_page){
                this.paginatorModel.set('start', start_page);
            }else{
                this.paginatorModel.set('start', total_page);
            }
            
            if(total_page > end_page){
                this.paginatorModel.set('end', end_page);
                next = true;
            }else{
                this.paginatorModel.set('end', total_page);
                next = false;
            }
           
        }else{
            previous = false;
            next = false;
            this.paginatorModel.set('start', 1);
            this.paginatorModel.set('end', total_page);
        }
        if(this.repliesCollection.length){
            var start = this.paginatorModel.get('start');
            var end = this.paginatorModel.get('end');
            this.$el.html("");
            
            for(var i = start; i <= end; i++){
                
                var is_active = (i == current_page) ? 'class="active"' : '';
                var enable_previous = (start == i) ? true : false;
                var enable_next = (end == i) ? true : false;
                
                var template = this.template({
                    is_active : is_active,
                    page :  this.routeModel.get('page'),
                    previous : previous,
                    next : next,
                    start : start - 1,
                    end : end + 1,
                    enable_previous : enable_previous,
                    enable_next : enable_next,
                    thread_id : thread_id,
                    id : i
                });
                this.$el.append(template);
            }
        }else{
            this.$el.html("");
        }
    }
});


App.View.Thread = Backbone.View.extend({
    
    initialize : function(opts) {
        this.routeModel = opts.routeModel;
        this.paginatorModel = opts.paginatorModel;
        this.repliesCollection = opts.repliesCollection;
        this.listenTo(this.model, 'change', this.render_replies);
        this.listenTo(this.routeModel, 'change:thread_id', this.render);
        this.listenTo(this.routeModel, 'change:thread_page', this.render_replies);
    },
    
    className : 'panel pane-default',
    
    events : {
        'click #delete_btn' : 'deleteForum',
        'click .collapsed' : 'openReply',
        'click #submit' : 'submitReply',
        'click #delete_replies' : 'deleteReply'
    },
    
    template : _.template($('#thread_template').html()),
    
    reply_template : _.template($('#replies_template').html()),
    
    render_replies : function() {
        
        this.$el.find('#replies').html("");
        if(_.size(this.model.get('replies'))){
            
            var current_page = this.routeModel.get('thread_page');
            var per_page = this.paginatorModel.get('per_page');
            var end = current_page * per_page;
            var start = (end - per_page) < 0 ? 0 : end - per_page;
            var replies = _(this.model.get('replies')).sortBy(function(obj) {
                return -obj.id
            });
            
            this.repliesCollection = new App.Collection.Replies(replies);
            var repliesSlice = this.repliesCollection.slice(start, end);
            if(repliesSlice.length) {
                _.each(repliesSlice, function(reply){
                    var disable_delete = (this.model.get('user_id') == username_id) ? true
                    : (reply.get('user_id') == username_id)
                    ? true : false;
                    reply.set({
                        'formatDate': formatDate(reply.get('date')),
                        'page' : this.routeModel.get('page'),
                        'thread_page' : this.routeModel.get('thread_page'),
                        'disable_delete' : disable_delete
                    },{
                        silent:true
                    });
                
                    var reply_template = this.reply_template(reply.toJSON());
                    this.$el.find('#replies').append(reply_template);
                },this);

                new App.View.Paginator.Replies({
                    repliesCollection : this.repliesCollection,
                    routeModel : routeModel, 
                    model : this.model,
                    paginatorModel : new App.Model.PaginatorModel,
                    el : this.$el.find('#reply_paginator_view ul')
                });
            
            }else{
                
                /* patch again... not good */
                if(this.model.get('id') == this.routeModel.get('thread_id')){
                    this.routeModel.set('thread_page', 1);
                    window.location = '#'+ this.routeModel.get('page') 
                    + '/thread/' + this.routeModel.get('thread_id') 
                    + '/' + this.routeModel.get('thread_page');
                }
            }
            
        }
    },
    
    render : function() {
       
        this.model.set('formatDate', formatDate(this.model.get('date')), {
            silent:true
        });
        this.model.set('page', this.routeModel.get('page'), {
            silent:true
        });
        var template = this.template(this.model.toJSON());
        this.$el.html(template);
        this.render_replies();
        
        /* patch again */
        var getHash = window.location.hash;
        getHash = getHash.split('/');
        /* show thread if thread is set */
        if(this.model.get('id') == this.routeModel.get('thread_id') && getHash.length > 2){

            $('#section_' + this.model.get('id'), this.$el).collapse('show');
            
        }
        
        return this;
    },
    
    deleteForum : function(e) {
        this.collection.remove(this.model);
        this.model.destroy();
        if(this.collection.length == 0){
            this.collection.reset();
        }
    },
    
    deleteReply : function(e) {
        var obj = $(e.currentTarget);
        var id = obj.data('id');
        var model = this.repliesCollection.get(id);
        this.repliesCollection.remove(model);
        model.destroy();
//        model.destroy({
//            success: function(data, response){
//                console.log(data.toJSON());
//                console.log(response);
//            }
//        });
        
        this.model.set('replies',this.repliesCollection.toJSON(),{
            silent:true
        });
        this.model.trigger('change');
        
    },
    
    openReply : function(e) {
        var obj = $(e.currentTarget);
        var dataUrl = obj.data('url');
        window.location = dataUrl;

        /* close all open replies */
        $('.pane-default').find('.in').collapse('hide');
    },

    submitReply : function(e) {
        var obj = $(e.currentTarget);
        var form = obj.parents('form');
        var message = $.trim(form.find('#message').val());
        var user_id = form.find('#user_id').val();
        var forum_id = this.routeModel.get('thread_id');
        var date = formatDate();
        var name = form.find('#name').val();
        var username = form.find('#username').val();
        var raw_data = {
            forum_id:forum_id, 
            user_id:user_id, 
            message:message, 
            date:date,
            name : name,
            username : username,
            formatDate : formatDate(date)
        };
        var data = [raw_data];
        var that = this;
        var getRelies = this.model.get('replies');

        if(!message) 
            return false;

        this.repliesCollection.fetch({
            data: raw_data,
            type: 'POST',
            dataType:'json',
            async : true
        }).done(function(result){
            raw_data.id = result.last_id;
            if(_.size(getRelies)){
                getRelies.unshift(raw_data);
                data = getRelies;
            }
            that.model.set('replies',data,{
                silent:true
            });
            that.model.trigger('change');
            form.find('#message').val("");
        });

       

//            if(_.size(getRelies)){
//                getRelies.unshift(raw_data);
//                data = getRelies;
//            }
//            this.model.set('replies', data,{silent:true});
//            this.model.save(null,{
//                success : function(all, response){
//                    raw_data.id = response.last_id;
//
//                    data[0].id = raw_data.id;
//                    that.model.set('replies', data,{silent:true});
//                    that.model.trigger('change');
//                    form.find('#message').val("");
//
//                }
//            });
        
        
        
        

        //        this.model.save(raw_data, {patch:true, success : function(daa, response){
        //                console.log(response)
        //                /* server side: zend 2
        //                 *  $content = json_decode($request->getContent());
        //                 * 
        //                 */
        //        }
        //        });

        //        console.log(raw_data); return false;

        //        this.model.fetch({
        //            data : raw_data,
        //            type : 'put',
        //            async : true
        //        }).done(function(result){
        //            raw_data.id = result.last_id;
        //            
        //            if(_.size(getRelies)){
        //                getRelies.unshift(raw_data);
        //                data = getRelies;
        //            }
        //            that.model.set('replies',data,{silent:true});
        //            that.model.trigger('change');
        //            form.find('#message').val("");
        //        })

        return false;
    }
    
    
});

App.View.Forum = Backbone.View.extend({
    
    initialize : function(opt) {
        this.routeModel = opt.routeModel;
        this.paginatorModel = opt.paginatorModel;
        this.listenTo(this.collection, 'reset', this.render);
        this.listenTo(this.collection, 'remove', this.render);
        this.listenTo(this.routeModel, 'change:page', this.render);
        this.render();
    },
    
    render : function() {
        this.$el.html("");
        var current_page = this.routeModel.get('page');
        var per_page = this.paginatorModel.get('per_page');
        var end = (current_page * per_page);
        var start = (end - per_page) < 0 ? 0 : end - per_page;
        var models = this.collection.slice(start, end);
        
        if(this.collection.length){
            
            if(models.length == 0) {
                window.length = '#1';
                this.routeModel.set('page', 1);
            }
            
            _.each(models, function(model){
                var disable_delete = model.get('user_id') == username_id ? true : false;
                model.set('disable_delete', disable_delete,{
                    silent:true
                });
                
                var threadView = new App.View.Thread({
                    collection : this.collection, 
                    model: model,
                    repliesCollection : new App.Collection.Replies(),
                    routeModel : this.routeModel,
                    paginatorModel : this.paginatorModel
                });
                
            
                this.$el.append(threadView.render().el);
            },this);
        
            
        }else{
            this.$el.html("no record found");
        }
        
    }
    
});

App.View.Forms = Backbone.View.extend({
    initialize : function(opts) {
        this.collectionCopy = opts.collectionCopy;
    },
    
    el : '#forum_forms',
    
    events :  {
        'click #add_form #submit' : 'addForum',
        'keyup #blog_search' : 'searchForum'
    },
    
    addForum : function(e) {
        e.preventDefault();
        var user_id = this.$el.find('#user_id').val();
        var username = this.$el.find('#username').val();
        var name = this.$el.find('#name').val();
        var message = $.trim(this.$el.find('#message').val());
        var date = formatDate();

        if(message){
            var data = {
                user_id : user_id, 
                message: message, 
                name:name, 
                username:username, 
                date:date
            };
            var that = this;

            this.collection.fetch({
                data: data,
                type: 'POST',
                dataType:'json',
                async : true
            }).done(function(result){
                result = _(result).sortBy(function(obj) {
                    return -obj.id
                });
                that.collection.reset(result);
                that.collectionCopy.reset(result);
            });
                
            $('#message').val("");
           
        }
        return false;
    },
    
    searchForum : function(e) {
        var data = $(e.currentTarget).val();
        var searchedData = [], resetData = [];
       
        this.collectionCopy.filter(function(model){
            resetData.push(model);
            var concatData = (model.get('name') + model.get('message')).toLowerCase();
               
            if(concatData.indexOf(data) != -1){
                searchedData.push(model);
            }
           
        },this);
       
        if(data){
            this.collection.reset(searchedData);
        }else{
            this.collection.reset(resetData);
        }
       
    }
});