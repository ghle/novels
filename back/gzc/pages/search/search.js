var app = getApp()
var https = require('../../utils/https.js')

Page({
  data: {
    // text:"这是一个页面"
    list: [],
    keys:[],
    tags:[],
    keyword: "",
    windowHeight: 0,//获取屏幕高度  
    hidden: true,
    page: 1,
    size: 20,
    hasMore: true,
    hasRefesh: false,
    hasSearch:false,
  },
  initWindowHeight: function () {
    //获取屏幕高度  
    var that = this;
    wx.getSystemInfo({
      success: function (res) {
        that.setData({
          //50是搜索顶部的高
          windowHeight: res.windowHeight-50
        })
      }
    })
  },
  onLoad: function (options) {
    var that = this;
    that.initWindowHeight();
    var keys= wx.getStorageSync("searchKeys")||[];
    that.initTags();
    that.setData({
      keys: keys
    });
  },
  initTags:function(){
    var that = this;
    var tags=wx.getStorageSync("searchHotKeys");
    if (tags){
      that.setData({
        tags: tags,
      });
      return;
    }
    var url = app.globalData.searchKeywords;
    wx.showLoading({
      title: '加载中',
      mark: true
    });
    https.get(url,
      function (res) {
        //7天缓存
        wx.setStorage({
          key: "searchKeysTime",
          data: new Date((new Date() / 1000 + 86400*7) * 1000).getTime()
        })
        wx.setStorage({
          key: "searchHotKeys",
          data: res.Data
        });
        that.setData({
          tags: res.Data,
        });
        wx.hideLoading();
      }, function (res) {
        wx.hideLoading();
        console.log(res);
      });
  },
  onReady: function () {
    // 页面渲染完成
  },
  onShow: function () {
    // 页面显示
  },
  onHide: function () {
    // 页面隐藏
  },
  onUnload: function () {
    // 页面关闭
  },
  keywordBind:function(e){
    var that = this;
    that.setData({
      keyword: e.detail.value
    })
  },
  deleteKeys:function(e){
    wx.removeStorageSync("searchKeys");
    this.setData({
      keys:[]
    });
  },
  addKeys:function(keyword){
    var keys = this.data.keys;
    keys.unshift(keyword);
    this.setData({
      keys: keys
    });
    wx.setStorageSync("searchKeys", keys);
  },
  submit:function(e){
    var that = this;
    that.execSearch(that.data.keyword);
  },
  search:function(e){
    var that = this;
    that.execSearch(e.detail.value);
  },
  execSearch:function(keyword){
    var that = this;
    that.data.hasSearch = true;
    wx.showLoading({
      title: '加载中',
      mark: true
    });
    var url = app.globalData.searchUrl + `?bname=${keyword}`;
    https.get(url,
      function (res) {
        if(res.code==400){
          wx.showToast({
            title: '请输入书名',
            icon: 'loading',
            duration: 500
          })
          return false;
        }else{
          console.log('+++++++++++');
          console.log(res);
          that.setData({
            list: res.data,
            keyword: keyword,
            hidden: true,
            hasSearch: true
          });
          that.addKeys(keyword);
          wx.hideLoading();
        }

      }, function (res) {

        that.addKeys(keyword);
        wx.hideLoading();
      });
  },
  back:function(e){
    var that = this;
    that.setData({
      list:[],
      keyword:"",
      hidden: true,
      hasSearch: false
    });
    that.initWindowHeight();
  },
  //点击事件处理
  clickDetail: function (e) {
    console.log(e);
    wx.navigateTo({
      url: `../detail/detail?id=${e.currentTarget.id}`
    });
  },
 

})