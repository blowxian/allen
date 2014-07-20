$(document).ready(function() {
    var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
        fontTarget = $('[title=Font]').siblings('.dropdown-menu');
    $.each(fonts, function (idx, fontName) {
        fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
    });

    $('#news-editor').wysiwyg();

    // Simple JavaScript Templating
    // John Resig - http://ejohn.org/ - MIT Licensed
    (function(){
        var cache = {};

        this.tmpl = function tmpl(str, data){
            // Figure out if we're getting a template, or if we need to
            // load the template - and be sure to cache the result.
            var fn = !/\W/.test(str) ?
                cache[str] = cache[str] ||
                    tmpl(document.getElementById(str).innerHTML) :

                // Generate a reusable function that will serve as a template
                // generator (and which will be cached).
                new Function("obj",
                    "var p=[],print=function(){p.push.apply(p,arguments);};" +

                        // Introduce the data as local variables using with(){}
                        "with(obj){p.push('" +

                        // Convert the template into pure JavaScript
                        str
                            .replace(/[\r\t\n]/g, " ")
                            .split("<%").join("\t")
                            .replace(/((^|%>)[^\t]*)'/g, "$1\r")
                            .replace(/\t=(.*?)%>/g, "',$1,'")
                            .split("\t").join("');")
                            .split("%>").join("p.push('")
                            .split("\r").join("\\'")
                        + "');}return p.join('');");

            // Provide some basic currying to the user
            return data ? fn( data ) : fn;
        };
    })();

    window.manageNews = {
        cache: {
            lang: 'cn'
        },
        conf: {
            menuList: {
                'manageNews': {
                    dom: 'manage-news',
                    name: '管理新闻',
                    func: function() {
                        manageNews.fetch_news_list();
                    }
                },
                'addNews': {
                    dom: 'add-news',
                    name: '新增新闻',
                    func: function() {
                        $('#news-title').val('');
                        $('#news-editor').html('');
                        $('#news-title-label').html('新增新闻');
                        $('#save-news-btn').show();
                        $('#update-news-btn').hide();
                    }
                }
            },
            langOption: {
                en: '英文',
                cn: '中文'
            }
        },
        init: function() {
            // 初始化侧边栏
            this.init_sidebar();
            // 初始化新闻语言选项
            this.init_lang_switch();
            // 初始化函数关联
            this.init_news_list();
            // 绑定页面内事件
            this.bind_event();
        },
        init_sidebar: function() {
            this.render_sidebar('manageNews');
        },
        render_sidebar: function( curMenu ) {
            var menuList = this.conf.menuList;

            $('#sidebar').html(tmpl($('#sidebar-tmpl').html(), {
                'curMenu': curMenu,
                'menuList': menuList
            }));
            for(var i in menuList) {
                if(curMenu == i) {
                    $('#' + menuList[i].dom).show();
                    if(menuList[i].func) {
                        menuList[i].func();
                    }
                } else {
                    $('#' + menuList[i].dom).hide();
                }
            }
        },
        init_lang_switch: function() {
            this.render_lang_switch('cn')
        },
        render_lang_switch: function( curLang ) {
            this.cache.lang = curLang;
            $('#lang-switch').html(tmpl($('#lang-switch-tmpl').html(), {
                'curLang': curLang,
                'langOption': this.conf.langOption
            }));
        },
        save_news: function() {
            var that = this;
            $('#news-content-wrap').mask('正在保存新闻...');
            $.ajax({
                type: "GET",
                url: "http://" + window.location.host + "/adminApi/add_news",
                data: {
                    newsTitle: $('#news-title').val(),
                    newsContent: $('#news-editor').cleanHtml(),
                    enableNewsCn: that.cache.lang == 'cn' ? 'on' : ''
                },
                dataType: 'json'
            })
                .done(function( json ) {
                    $('#news-content-wrap').unmask();
                    switch(json.ret) {
                        case 0:
                            alert('新闻保存成功！');
                            manageNews.render_sidebar('manageNews');
                            break;
                        default:
                            alert('新闻保存失败！错误码：' + json.ret);
                            break;
                    }
                });
        },
        init_news_list: function() {
            this.conf.menuList['manageNews'].func = this.fetch_news_list;
        },
        fetch_news_list: function() {
            $('#news-list-wrap').mask('正在加载...');
            $.ajax({
                type: "GET",
                url: "http://" + window.location.host + "/adminApi/get_news_list",
                data: {
                    t: new Date().getTime()
                },
                dataType: 'json'
            })
                .done(function( json ) {
                    $('#news-list-wrap').unmask();
                    switch(json.ret) {
                        case 0:
                            manageNews.render_news_list(json.newsList);
                            break;
                        default:
                            alert('获取新闻列表失败！错误码：' + json.ret);
                            break;
                    }
                });
        },
        render_news_list: function( newsList ) {
            $('#news-list').html(tmpl($('#news-list-tmpl').html(), {
                'newsList': newsList
            }));
        },
        delete_news: function( newsId ) {
            $('#news-list-wrap').mask('正在删除...');
            $.ajax({
                type: "GET",
                url: "http://" + window.location.host + "/adminApi/del_news",
                data: {
                    'newsId': newsId
                },
                dataType: 'json'
            })
                .done(function( json ) {
                    $('#news-list-wrap').unmask();
                    switch(json.ret) {
                        case 0:
                            alert('新闻删除成功！');
                            manageNews.fetch_news_list();
                            break;
                        default:
                            alert('新闻删除失败！错误码：' + json.ret);
                            break;
                    }
                });
        },
        render_update_news: function( newsId ) {
            var menuList = this.conf.menuList;

            for(var i in menuList) {
                if('addNews' == i) {
                    $('#' + menuList[i].dom).show();
                    if(menuList[i].func) {
                        menuList[i].func();
                    }
                } else {
                    $('#' + menuList[i].dom).hide();
                }
            }

            $('#news-title-label').html('编辑新闻');
            $('#save-news-btn').hide();
            $('#update-news-btn').attr('newsid', newsId);
            $('#update-news-btn').show();

            $('#news-content-wrap').mask('正在加载...');

            $.ajax({
                type: "GET",
                url: "http://" + window.location.host + "/adminApi/get_news",
                data: {
                    'newsId': newsId
                },
                dataType: 'json'
            })
                .done(function( json ) {
                    $('#news-content-wrap').unmask();
                    switch(json.ret) {
                        case 0:
                            $('#news-title').val(json.data.page_title);
                            $('#news-editor').html(json.data.page_content);
                            break;
                        default:
                            alert('新闻获取失败！错误码：' + json.ret);
                            break;
                    }
                });
        },
        update_news: function( newsId ) {
            $('#news-content-wrap').mask('正在更新...');
            $.ajax({
                type: "GET",
                url: "http://" + window.location.host + "/adminApi/update_news",
                data: {
                    'newsId': newsId,
                    newsTitle: $('#news-title').val(),
                    newsContent: $('#news-editor').cleanHtml()
                },
                dataType: 'json'
            })
                .done(function( json ) {
                    $('#news-content-wrap').unmask();
                    switch(json.ret) {
                        case 0:
                            alert('新闻更新成功！');
                            manageNews.render_sidebar('manageNews');
                            break;
                        default:
                            alert('新闻更新失败！错误码：' + json.ret);
                            break;
                    }
                });
        },
        bind_event: function() {
            var that = this;
            $('#container').click(function( e ) {
                var action = $(e.target).attr('action');

                switch(action) {
                    case 'switch-tab':
                        that.render_sidebar($(e.target).attr('tabid'));
                        break;
                    case 'switch-lang':
                        that.render_lang_switch($(e.target).attr('langid'));
                        break;
                    case 'save-news':
                        that.save_news();
                        break;
                    case 'edit-news':
                        that.render_update_news($(e.target).attr('newsid'));
                        break;
                    case 'update-news':
                        that.update_news($(e.target).attr('newsid'));
                        break;
                    case 'reset-news':
                        if(confirm('重置将不保存任何信息，确定重置？')) {
                            $('#news-title').val('');
                            $('#news-editor').html('');
                        }
                        break;
                    case 'del-news':
                        that.delete_news($(e.target).attr('newsid'));
                        break;
                    default:
                        break;
                }
            });
        }
    };

    window.manageCategory = {
        cache: {
            lang: 'cn',
            domList: {
                'level1': $('#category-list-level-1'),
                'level2': $('#category-list-level-2'),
                'level3': $('#category-list-level-3'),
                'level4': $('#category-list-level-4')
            },
            selectedCate: {
                'level0': 0,
                'level1': 0,
                'level2': 0,
                'level3': 0,
                'level4': 0
            }
        },
        conf: {
            langOption: {
                en: '英文',
                cn: '中文'
            }
        },
        init: function() {
            // 初始化现有类目
            this.init_category_selector();
            // 初始化事件代理
            this.bind_event();
            // 初始化语言选项
            this.init_lang_switch();
        },
        init_category_selector: function() {
            // 获取类目数据
            this.fetch_category();
        },
        fetch_category: function() {
            $('#cate-list-wrap').mask('正在加载...');
            $.ajax({
                type: "GET",
                url: "http://" + window.location.host + "/adminApi/get_all_category",
                data: {
                    t: new Date().getTime()
                },
                dataType: 'json'
            })
                .done(function( json ) {
                    $('#cate-list-wrap').unmask();
                    switch(json.ret) {
                        case 0:
                            manageCategory.render_category_selector(manageCategory.convert_to_category_tree(json.categoryList));
                            break;
                        default:
                            alert('加载类目失败！错误码：' + json.ret);
                            break;
                    }
                });
        },
        init_lang_switch: function() {
            this.render_lang_switch('cn')
        },
        render_lang_switch: function( curLang ) {
            this.cache.lang = curLang;
            $('#lang-switch').html(tmpl($('#lang-switch-tmpl').html(), {
                'curLang': curLang,
                'langOption': this.conf.langOption
            }));
        },
        render_category_selector: function( categoryTree ) {
            this.init_category_tree();

            var dl = this.cache.domList,
                ct = categoryTree,
                index = 1;

            for(var i in dl) {
                dl[i].html('');
            }

            while('0' in ct) {
                if('children' in ct['0']) {
                    ct = ct['0'].children;
                    this.render_category_list(ct, dl['level' + index], index);
                    index++;
                } else {
                    break;
                }
            }
        },
        render_category_list: function( categoryList, dom, level ) {
            dom.html(tmpl($('#category-list-tmpl').html(), {
                'categoryList': categoryList,
                'level': level
            }));
        },
        render_add_category: function( dom, level ) {
            dom.html(tmpl($('#add-category-tmpl').html(), {
                'level': level
            }) + dom.html());
        },
        init_category_tree: function() {
            var ct = this.cache.categoryTree,
                sc = this.cache.selectedCate,
                level = 0;

            while('0' in ct) {
                sc['level' + level] = ct['0'];
                ct['0']['selected'] = 1;
                if('children' in ct['0']) {
                    ct = ct['0'].children;
                    level++;
                } else {
                    break;
                }
            }
        },
        update_category_tree: function( option ) {
            switch(option.action) {
                case 'update-select':
                    var ct = this.cache.categoryTree,
                        dl = this.cache.domList,
                        sc = this.cache.selectedCate,
                        level = 0;

                    while('0' in ct) {
                        if(level < option.level) {
                            for(var i in ct) {
                                if('selected' in ct[i] && ct[i].selected) {
                                    sc['level' + level] = ct[i];
                                    if('children' in ct[i]) {
                                        ct = ct[i].children;
                                        level++;
                                    }
                                    break;
                                }
                            }
                        } else if(level == option.level && option.cateno in ct) {
                            for(var i in ct) {
                                ct[i]['selected'] = 0;
                            }
                            sc['level' + level] = ct[option.cateno];
                            ct[option.cateno]['selected'] = 1;

                            this.render_category_list(ct, dl['level' + level], level);

                            if('children' in ct[option.cateno]) {
                                ct = ct[option.cateno].children;
                                level++;
                            } else {
                                break;
                            }
                        } else {
                            for(var i in ct) {
                                ct[i]['selected'] = 0;
                            }
                            sc['level' + level] = ct['0'];
                            ct['0']['selected'] = 1;

                            if(level > 0) {
                                this.render_category_list(ct, dl['level' + level], level);
                            }

                            if('children' in ct['0']) {
                                ct = ct['0'].children;
                                level++;
                            } else {
                                break;
                            }
                        }
                    }
                    for(++level; level < 4; level++) {
                        this.render_category_list({}, dl['level' + level], level);
                    }
                    break;
                case 'update-add':
                    break;
                case 'update-delete':
                    break;
            }
        },
        add_category: function( option ) {
            var that = this;
            $('#cate-list-wrap').mask('正在添加类目...');
            $.ajax({
                type: "GET",
                url: "http://" + window.location.host + "/adminApi/add_category",
                data: {
                    categoryName: $('#add-category-level-' + option.level).val(),
                    parentId: option.pid,
                    categoryDesc: '',
                    categoryCover: '',
                    categoryLang: that.cache.curLang == 'cn' ? 2 : 1
                },
                dataType: 'json'
            })
                .done(function( json ) {
                    $('#cate-list-wrap').unmask();
                    switch(json.ret) {
                        case 0:
                            alert('类目添加成功！');
                            $('button[data-action="render-add"]').attr('disabled', false);
                            that.fetch_category();
                            break;
                        default:
                            alert('类目添加失败！错误码：' + json.ret);
                            break;
                    }
                });
        },
        del_category: function( cateId ) {
            var that = this;
            $('#cate-list-wrap').mask('正在删除类目...');
            $.ajax({
                type: "GET",
                url: "http://" + window.location.host + "/adminApi/del_category",
                data: {
                    categoryId: cateId
                },
                dataType: 'json'
            })
                .done(function( json ) {
                    $('#cate-list-wrap').unmask();
                    switch(json.ret) {
                        case 0:
                            alert('类目删除成功！');
                            that.fetch_category();
                            break;
                        default:
                            alert('类目删除失败！错误码：' + json.ret);
                            break;
                    }
                });
        },
        fetch_category_detail: function( cateId ) {
            var that = this;
            $('#cate-detail-wrap').mask('正在加载类目详情...');
            $.ajax({
                type: "GET",
                url: "http://" + window.location.host + "/adminApi/get_category_detail",
                data: {
                    categoryId: cateId
                },
                dataType: 'json'
            })
                .done(function( json ) {
                    $('#cate-detail-wrap').unmask();
                    switch(json.ret) {
                        case 0:
                            that.render_category_detail(json.categoryDetail[0]);
                            break;
                        default:
                            alert('加载类目详情失败！错误码：' + json.ret);
                            break;
                    }
                });
        },
        render_category_detail: function( cateDetail ) {
            this.render_lang_switch(cateDetail.category_lang == '1' ? 'en' : 'cn');
            $('#cate-id').val(cateDetail.category_id);
            $('#cate-title').val(cateDetail.category_name);
            $('#cate-desc').val(cateDetail.category_desc);
            $('cate-cover-url').val(cateDetail.category_cover);
            if(cateDetail.category_cover == '') {
                Holder.run();
            } else {
                $('#cate-cover-loading').show().css({ opacity: .8 });
                $('#cate-cover').attr('src', 'http://' + window.location.host + '/img/product/cover/' + cateDetail.category_cover).load(function() {
                    $('#cate-cover-loading').hide();
                });
            }
        },
        update_category: function() {
            $('#cate-detail-wrap').mask('正在更新类目...');
            $.ajax({
                type: "GET",
                url: "http://" + window.location.host + "/adminApi/update_category_detail",
                data: {
                    categoryId: $('#cate-id').val(),
                    categoryName: $('#cate-title').val(),
                    categoryDesc: $('#cate-desc').val(),
                    categoryCover: $('#cate-cover-url').val(),
                    categoryLang: this.cache.lang
                },
                dataType: 'json'
            })
                .done(function( json ) {
                    $('#cate-detail-wrap').unmask();
                    switch(json.ret) {
                        case 0:
                            alert('类目更新成功！');
                            break;
                        default:
                            alert('类目更新失败！错误码：' + json.ret);
                            break;
                    }
                });
        },
        bind_event: function() {
            var that = this;
            $('#cate-list-wrap').click(function( e ) {
                var action = $(e.target).data('action');

                switch(action) {
                    case 'select':
                        that.update_category_tree({
                            action: 'update-select',
                            level: $(e.target).data('level'),
                            cateno: $(e.target).data('cateno')
                        });
                        that.fetch_category_detail($(e.target).data('cateid'));
                        break;
                    case 'render-add':
                        var categoryList = that.cache.domList['level' + $(e.target).data('level')].parent();
                        that.render_add_category(that.cache.domList['level' + $(e.target).data('level')], $(e.target).data('level'));
                        categoryList.animate({scrollTop: 0}, 0);
                        $(e.target).attr('disabled', true);
                        break;
                    case 'add':
                        that.add_category({
                            level: $(e.target).data('level'),
                            pid: that.cache.selectedCate['level' + ($(e.target).data('level') - 1)].category_id
                        });
                        break;
                    case 'delete':
                        if(confirm("确定删除类目吗？该目录下的子目录以及商品均会被删除。")) {
                            that.del_category($(e.target).data('cateid'));
                        }
                        break;
                }
            });

            // 上传封面图片
            $("#submit-cate-cover-image").on('click', function() {
                $('#upload-cate-cover-wrap').mask('正在上传类目封面...');
                $("#imageform").ajaxForm(
                    {
                        target: '#cate-cover-wrap'
                    }).submit();
            });

            // 更新类目信息
            $("#update-category-btn").on('click', function() {
                that.update_category();
            });

            $("#lang-switch").click(function( e ) {
                var action = $(e.target).attr('action');

                switch(action) {
                    case 'switch-lang':
                        that.render_lang_switch($(e.target).attr('langid'));
                        break;
                    default:
                        break;
                }
            });
        },
        convert_to_category_tree: function( categoryList ) {
            var cateList = $.extend([], categoryList),
                cateIdList = ['0'],
                cateObjList = {0 : {
                    category_id: 0
                }};

            while(cateList.length > 0) {
                var flag = false;
                for(var i = 0; i < cateList.length; i++) {
                    var index = cateIdList.indexOf(cateList[i].parent_id);
                    if(index != -1) {
                        flag = true;
                        if(!('children' in cateObjList[cateIdList[index]])) {
                            cateObjList[cateIdList[index]]['children'] = [];
                        }
                        cateObjList[cateIdList[index]].children.push(cateList[i]);
                        cateObjList[cateList[i].category_id] = cateList[i];
                        cateIdList.push(cateList[i].category_id);
                        cateList.splice(i, 1);
                        i--;
                    }
                }

                if(!flag) {
                    break;
                }
            }
            this.cache.categoryTree = {'0': cateObjList['0']};

            return this.cache.categoryTree;
        }
    };

    window.manageProduct = {
        cache: {
            lang: 'cn',
            domList: {
                'level1': $('#category-list-level-1'),
                'level2': $('#category-list-level-2'),
                'level3': $('#category-list-level-3'),
                'level4': $('#category-list-level-4')
            },
            selectedCate: {
                'level0': 0,
                'level1': 0,
                'level2': 0,
                'level3': 0,
                'level4': 0
            }
        },
        conf: {
            menuList: {
                'manageProduct': {
                    dom: 'manage-product',
                    name: '管理商品',
                    func: function() {
                        manageProduct.init_product_search_tab();
                    }
                },
                'addProduct': {
                    dom: 'add-product',
                    name: '新增商品',
                    func: function() {
                        $('#create-product-button').show();
                        $('#update-modified-product-button').hide();
                    }
                },
                'modifyProduct': {
                    dom: 'add-product',
                    name: '修改商品',
                    func: function() {
                        $('#create-product-button').hide();
                        $('#update-modified-product-button').show();
                    }
                }
            },
            tabList: {
                'byKeyword': {
                    dom: 'search-product-by-keyword',
                    name: '通过关键字查找商品',
                    func: function() {
                    }
                }/*,
                'byCategory': {
                    dom: 'search-product-by-category',
                    name: '通过类目查找商品',
                    func: function() {
                    }
                }*/
            },
            langOption: {
                en: '英文',
                cn: '中文'
            },
            queryProductPageSize: 20
        },
        init: function() {
            // 初始化侧边栏
            this.init_sidebar();
            // 初始化语言选项
            this.init_lang_switch();
            // 绑定页面内事件
            this.bind_event();
            // 初始化类目选择器
            this.init_category_selector();
        },
        init_lang_switch: function() {
            this.render_lang_switch('cn')
        },
        render_lang_switch: function( curLang ) {
            this.cache.lang = curLang;
            $('#lang-switch').html(tmpl($('#lang-switch-tmpl').html(), {
                'curLang': curLang,
                'langOption': this.conf.langOption
            }));
        },
        init_category_selector: function() {
            // 获取类目数据
            this.fetch_category();
        },
        fetch_category: function() {
            $('#cate-list-wrap').mask('正在加载...');
            $.ajax({
                type: "GET",
                url: "http://" + window.location.host + "/adminApi/get_all_category",
                data: {
                    t: new Date().getTime()
                },
                dataType: 'json'
            })
                .done(function( json ) {
                    $('#cate-list-wrap').unmask();
                    switch(json.ret) {
                        case 0:
                            manageProduct.cache.categoryList = $.extend([], json.categoryList);
                            manageProduct.render_category_selector(manageProduct.convert_to_category_tree(json.categoryList));
                            break;
                        default:
                            alert('加载类目失败！错误码：' + json.ret);
                            break;
                    }
                });
        },
        fetch_product: function( pid ) {
            $('#add-product-main').mask('正在加载...');
            $.ajax({
                type: "GET",
                url: "http://" + window.location.host + "/adminApi/get_product_by_id",
                data: {
                    productId: pid,
                    t: new Date().getTime()
                },
                dataType: 'json'
            })
                .done(function( json ) {
                    $('#add-product-main').unmask();
                    switch(json.ret) {
                        case 0:
                            manageProduct.render_modify_product(json.product);
                            break;
                        default:
                            alert('加载商品失败！错误码：' + json.ret);
                            break;
                    }
                });
        },
        init_sidebar: function() {
            this.render_sidebar('menu' in this.get_url_vars() ? this.get_url_vars().menu : 'manageProduct');
        },
        render_sidebar: function( curMenu ) {
            var menuList = this.conf.menuList;

            $('#sidebar').html(tmpl($('#sidebar-tmpl').html(), {
                'curMenu': curMenu,
                'menuList': menuList
            }));

            var domId = null;
            for(var i in menuList) {
                if(curMenu == i) {
                    domId = '#' + menuList[i].dom;
                    if(menuList[i].func) {
                        menuList[i].func();
                    }

                } else {
                    $('#' + menuList[i].dom).hide();
                }
            }
            $(domId).show();
        },
        render_category_selector: function( categoryTree ) {
            this.init_category_tree();

            var dl = this.cache.domList,
                ct = categoryTree,
                index = 1;

            for(var i in dl) {
                dl[i].html('');
            }

            while('0' in ct) {
                if('children' in ct['0']) {
                    ct = ct['0'].children;
                    this.render_category_list(ct, dl['level' + index], index);
                    index++;
                } else {
                    break;
                }
            }
        },
        render_category_list: function( categoryList, dom, level ) {
            dom.html(tmpl($('#category-list-tmpl').html(), {
                'categoryList': categoryList,
                'level': level
            }));
        },
        init_category_tree: function() {
            var ct = this.cache.categoryTree,
                sc = this.cache.selectedCate,
                level = 0;

            while('0' in ct) {
                sc['level' + level] = ct['0'];
                ct['0']['selected'] = 1;
                if('children' in ct['0']) {
                    ct = ct['0'].children;
                    level++;
                } else {
                    break;
                }
            }
        },
        update_category_tree: function( option ) {
            switch(option.action) {
                case 'update-select':
                    var ct = this.cache.categoryTree,
                        dl = this.cache.domList,
                        sc = this.cache.selectedCate,
                        level = 0;

                    while('0' in ct) {
                        if(level < option.level) {
                            for(var i in ct) {
                                if('selected' in ct[i] && ct[i].selected) {
                                    sc['level' + level] = ct[i];
                                    if('children' in ct[i]) {
                                        ct = ct[i].children;
                                        level++;
                                    }
                                    break;
                                }
                            }
                        } else if(level == option.level && option.cateno in ct) {
                            for(var i in ct) {
                                ct[i]['selected'] = 0;
                            }
                            sc['level' + level] = ct[option.cateno];
                            ct[option.cateno]['selected'] = 1;

                            this.render_category_list(ct, dl['level' + level], level);

                            if('children' in ct[option.cateno]) {
                                ct = ct[option.cateno].children;
                                level++;
                            } else {
                                break;
                            }
                        } else {
                            for(var i in ct) {
                                ct[i]['selected'] = 0;
                            }
                            sc['level' + level] = ct['0'];
                            ct['0']['selected'] = 1;

                            if(level > 0) {
                                this.render_category_list(ct, dl['level' + level], level);
                            }

                            if('children' in ct['0']) {
                                ct = ct['0'].children;
                                level++;
                            } else {
                                break;
                            }
                        }
                    }
                    for(++level; level < 4; level++) {
                        sc['level' + level] = 0;
                        this.render_category_list({}, dl['level' + level], level);
                    }
                    break;
                case 'update-add':
                    break;
                case 'update-delete':
                    break;
            }
        },
        update_selected_category: function() {
            $('#selected-category-id').val(this.get_selected_category_id());
            $('#selected-category-trace').val(this.get_selected_category_trace());
            $('#cate-selector-wrap').slideToggle();
        },
        get_selected_category_id: function() {
            var that = this,
                sc = that.cache.selectedCate,
                selectedCateId = 0;

            for(var i = this.size(sc) - 1; i > 0; i--) {
                if(sc['level' + i] != 0) {
                    selectedCateId = sc['level' + i].category_id;
                    break;
                }
            }

            return selectedCateId;
        },
        get_selected_category_trace: function() {
            var sc = this.cache.selectedCate,
                traceText = "";

            for(var i = 1; i < this.size(sc); i++) {
                if(sc['level' + i] != 0) {
                    traceText += (i == 1 ? sc['level' + i].category_name : ' > ' + sc['level' + i].category_name);
                }
            }

            return traceText;
        },
        add_product_spec: function() {
            $('#product-spec tr:last').after(tmpl($('#product-spec-tmpl').html(), {
                productNo: '',
                productSize: '',
                productUnitPrice: ''
            }));
        },
        remove_product_spec: function( dom ) {
            while($(dom).prop('tagName') != 'TR' && $(dom).prop('tagName') != 'BODY') {
                dom = $(dom).parent();
            }

            if($(dom).prop('tagName') == 'TR') {
                $(dom).remove();
            }
        },
        create_product: function() {
            var that = this;
            $('#add-product').mask('正在创建商品...');
            $.ajax({
                type: "GET",
                url: "http://" + window.location.host + "/adminApi/add_product",
                data: {
                    productName: $('#product-name').val(),
                    productNO: $('#product-no').val(),
                    productPrice: $('#product-price').val(),
                    productMOQ: $('#product-moq').val(),
                    productMaterial: $('#product-material').val(),
                    productImage: $('#product-image-url').val(),
                    productSmallImage: $('#product-small-image-url').val(),
                    productHugeImage: "",
                    productCategory: $('#selected-category-id').val(),
                    productSpec: $('.product-spec-item').map(function(){return $(this).val()}).get().join(','),
                    productLang: that.cache.lang == 'cn' ? 2 : 1,
                    t: new Date().getTime()
                },
                dataType: 'json'
            })
                .done(function( json ) {
                    $('#add-product').unmask();
                    switch(json.ret) {
                        case 0:
                            alert('商品创建成功！即将跳转商品管理页面。');
                            that.render_sidebar('manageProduct');
                            break;
                        default:
                            alert('商品创建失败！错误码：' + json.ret);
                            break;
                    }
                });
        },
        init_product_search_tab: function() {
            this.switch_product_search_tab('byKeyword');
        },
        switch_product_search_tab: function( curTab ) {
            var tabList = this.conf.tabList;

            $('#product-search-tab').html(tmpl($('#switch-product-search-tab-tmpl').html(), {
                'curTab': curTab,
                'tabList': tabList
            }));
            for(var i in tabList) {
                if(curTab == i) {
                    $('#' + tabList[i].dom).show();
                    if(tabList[i].func) {
                        tabList[i].func();
                    }
                } else {
                    $('#' + tabList[i].dom).hide();
                }
            }

            $('#query-product-result').hide();
        },
        query_product_by_keyword: function( keyword ) {
            var that = this;
            $('#query-product-result').mask('正在检索商品...');
            that.cache.curPage = arguments.length >= 2 ? arguments[1] : 1;
            $.ajax({
                type: "GET",
                url: "http://" + window.location.host + "/adminApi/query_product_by_keyword",
                data: {
                    keyword: $('#keyword').val(),
                    pageNum: that.cache.curPage,
                    pageSize: that.conf.queryProductPageSize
                },
                dataType: 'json'
            })
                .done(function( json ) {
                    $('#query-product-result').unmask();
                    switch(json.ret) {
                        case 0:
                            that.render_query_product_result(json);
                            break;
                        default:
                            alert('商品检索失败！错误码：' + json.ret);
                            break;
                    }
                });
        },
        render_query_product_result: function( queryJSON ) {
            var that = this;
            $('#query-product-result-list').html(tmpl($('#query-product-result-tmpl').html(), queryJSON));
            $('.pagination').jqPagination({
                current_page: queryJSON.pageNum,
                max_page: queryJSON.totalPageNum,
                paged: function(page) {
                    that.query_product_by_keyword($('#keyword').val(), page);
                }
            });
            $('#query-product-result').show();
        },
        render_modify_product: function( product ) {
            // 填充现有商品数据
            $("#product-id").val(product.product_id);
            $("#product-name").val(product.product_name);
            $("#product-no").val(product.product_desc.split(',')[0]);
            $("#product-price").val(product.product_desc.split(',')[1]);
            $("#product-moq").val(product.product_desc.split(',')[2]);
            $("#product-material").val(product.product_desc.split(',')[3]);
            $($("#product-image-wrap").children("img")[0]).attr('src', '../img/product/large/' + product.product_img_large);
            $($("#product-image-wrap").children("img")[1]).attr('src', '../img/product/small/' + product.product_img_small);
            $("#product-image-url").val(product.product_img_large);
            $("#product-small-image-url").val(product.product_img_small);
            $("#selected-category-trace").val(this.get_category_trace(product.product_category));
            $("#selected-category-id").val(product.product_category);

            // 填充商品规格
            var spec_array = product.product_spec.split(',');
            $('#product-spec tbody tr').each(function(index) {
                if(index >= 1) {
                    $(this).remove();
                }
            });
            if(spec_array.length / 3 >= 2) {
                for(var i = 1; i < (spec_array.length / 3); i++) {
                    this.add_product_spec();
                }
            }
            $('.product-spec-item').each(function(index) {
                $(this).val(spec_array[index]);
            });
        },
        update_modified_product: function() {
            var that = this;
            $('#add-product').mask('正在更新商品...');
            $.ajax({
                type: "GET",
                url: "http://" + window.location.host + "/adminApi/update_product",
                data: {
                    productId: $('#product-id').val(),
                    productName: $('#product-name').val(),
                    productNO: $('#product-no').val(),
                    productPrice: $('#product-price').val(),
                    productMOQ: $('#product-moq').val(),
                    productMaterial: $('#product-material').val(),
                    productImage: $('#product-image-url').val(),
                    productSmallImage: $('#product-small-image-url').val(),
                    productHugeImage: "",
                    productCategory: $('#selected-category-id').val(),
                    productSpec: $('.product-spec-item').map(function(){return $(this).val()}).get().join(','),
                    productLang: that.cache.lang == 'cn' ? 2 : 1,
                    t: new Date().getTime()
                },
                dataType: 'json'
            })
                .done(function( json ) {
                    $('#add-product').unmask();
                    switch(json.ret) {
                        case 0:
                            alert('商品更新成功！即将跳转商品管理页面。');
                            that.render_sidebar('manageProduct');
                            break;
                        default:
                            alert('商品更新失败！错误码：' + json.ret);
                            break;
                    }
                });
        },
        delete_product: function( pid ) {
            var that = this;
            $('#query-product-result').mask('正在删除商品...');
            $.ajax({
                type: "GET",
                url: "http://" + window.location.host + "/adminApi/del_product",
                data: {
                    productId: pid,
                    t: new Date().getTime()
                },
                dataType: 'json'
            })
                .done(function( json ) {
                    $('#query-product-result').unmask();
                    switch(json.ret) {
                        case 0:
                            that.query_product_by_keyword($('#keyword').val(), (that.cache.curPage ? that.cache.curPage : 1));
                            break;
                        default:
                            alert('商品删除失败！错误码：' + json.ret);
                            break;
                    }
                });
        },
        bind_event: function() {
            var that = this;
            $('#container').click(function( e ) {
                var action = $(e.target).data('action');

                switch(action) {
                    case 'select':
                        that.update_category_tree({
                            action: 'update-select',
                            level: $(e.target).data('level'),
                            cateno: $(e.target).data('cateno')
                        });
                        break;
                    case 'switch-lang':
                        that.render_lang_switch($(e.target).attr('langid'));
                        break;
                    case 'switch-tab':
                        that.render_sidebar($(e.target).attr('tabid'));
                        break;
                    case 'confirm-category':
                        that.update_selected_category();
                        break;
                    case 'cancel-category':
                        $('#cate-selector-wrap').slideToggle();
                        break;
                    case 'add-product-spec':
                        that.add_product_spec();
                        break;
                    case 'remove-product-spec':
                        that.remove_product_spec(e.target);
                        break;
                    case 'create-product':
                        that.create_product();
                        break;
                    case 'switch-product-search-tab':
                        that.switch_product_search_tab($(e.target).attr('tabid'));
                        break;
                    case 'query-product-by-keyword':
                        that.query_product_by_keyword($('keyword').val());
                        break;
                    case 'modify-product':
                        that.render_sidebar('modifyProduct');
                        that.fetch_product($(e.target).data('pid'));
                        break;
                    case 'update-modified-product':
                        that.update_modified_product();
                        break;
                    case 'delete-product':
                        that.delete_product($(e.target).data('pid'));
                        break;
                    default:
                        break;
                }
            });

            // 上传封面图片
            $("#submit-product-image").on('click', function() {
                $('#upload-product-image-wrap').mask('正在上传类目封面...');
                $("#imageform").ajaxForm(
                    {
                        target: '#product-image-wrap'
                    }).submit();
            });

            // 展开类目选择器
            $('#trigger-category-selector').on('click', function() {
                $('#cate-selector-wrap').slideToggle();
            })

            // 回车搜索商品
            $('#keyword').on("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode == 13) {
                    that.query_product_by_keyword($('keyword').val());
                }
            });
        },
        convert_to_category_tree: function( categoryList ) {
            var cateList = $.extend([], categoryList),
                cateIdList = ['0'],
                cateObjList = {0 : {
                    category_id: 0
                }};

            while(cateList.length > 0) {
                var flag = false;
                for(var i = 0; i < cateList.length; i++) {
                    var index = cateIdList.indexOf(cateList[i].parent_id);
                    if(index != -1) {
                        flag = true;
                        if(!('children' in cateObjList[cateIdList[index]])) {
                            cateObjList[cateIdList[index]]['children'] = [];
                        }
                        cateObjList[cateIdList[index]].children.push(cateList[i]);
                        cateObjList[cateList[i].category_id] = cateList[i];
                        cateIdList.push(cateList[i].category_id);
                        cateList.splice(i, 1);
                        i--;
                    }
                }

                if(!flag) {
                    break;
                }
            }
            this.cache.categoryTree = {'0': cateObjList['0']};

            return this.cache.categoryTree;
        },
        size: function(obj) {
            var size = 0,
                key;

            for(key in obj) {
                if(obj.hasOwnProperty(key)) size++;
            }

            return size;
        },
        get_url_vars: function ()
        {
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1);
            hashes = hashes.slice(0, hashes.indexOf('#')).split('&');
            for(var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        },
        get_category_name: function( cid ) {
            var cl = this.cache.categoryList;
            for(var i in cl) {
                if(cl[i].category_id == cid) {
                    return cl[i].category_name;
                }
            }
        },
        get_category_parent: function( cid ) {
            if(!~~cid) {
                return 0;
            } else {
                var cl = this.cache.categoryList;
                for(var i in cl) {
                    if(cl[i].category_id == cid) {
                        return cl[i].parent_id;
                    }
                }
            }
        },
        get_category_trace: function( cid ) {
            var trace = "";
            while(cid != 0) {
                trace = this.get_category_name(cid) + (trace != "" ? " > " + trace : trace);

                cid = this.get_category_parent(cid);
            }

            return trace;
        }
    };
});