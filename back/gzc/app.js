//app.js 
var https = require('utils/https.js')
var url ="http://39.106.134.4";
App({
 
  globalData: {
    // 图书详情
    detailUrl: url+"/novels/public/index.php/index/index/booksdetail",
    // 图书列表
    novelsUrl: url +"/novels/public/index.php/index/index/bookslist",
    // 首页推荐
    indexrecommend: url + "/novels/public/index.php/index/index/indexrecommend",
    // 首页分类导航
    categoryUrl: url +"/novels/public/",
    // 文章详情
    chaptersContentUrl: url +"/novels/public/index.php/index/index/articlesdetail",
    // 搜索
    searchUrl: url +"/novels/public/index.php/index/index/search",
    searchKeywords: url +"/novels/public/index.php/index/index/search",
    // 反馈
    feedbackUrl: url +"/novels/public/index.php/index/index/feedback",

  
    token:null,
    userInfo: null
  },
   onLaunch: function () {
    // wx.clearStorage();
    this.getUserInfo();
    this.removeCache();
  },
  removeCache:function(){
    var value = wx.getStorageSync('cateListTime')
    var nowTime = new Date().getTime();
    if(value){
      if (value < nowTime) {
        wx.removeStorage("cateList");
      }
    }
    value = wx.getStorageSync('searchKeysTime')
    if (value) {
      if (value < nowTime) {
        wx.removeStorage("searchKeysTime");
      }
    }
  },
  WechatLogin:function(){
    var that = this
    wx.login({
      success: function (res) {
        //登录成功 
        if (res.code) {
          // 这里是用户的授权信息每次都不一样 
          var code = res.code;
          wx.getUserInfo({
            success: function (info) {
              wx.setStorageSync('userInfo', info.userInfo);
              that.globalData.userInfo = info.userInfo;
              typeof cb == "function" && cb(that.globalData.userInfo)
              // 请求自己的服务器 
            
            },fail:function(e){
              console.log(e);
            }
          })
        }
      }, fail: function (e) {
         console.log(e);
      }
    })
  },
  getUserInfo: function (cb) {
  
    var that = this
    if (this.globalData.userInfo) {
      console.log(cb);
      typeof cb == "function" && cb(this.globalData.userInfo)
    } else {
        wx.checkSession({
        success: function () {
          var userInfo=wx.getStorageSync('userInfo');
          if(userInfo){
            that.globalData.userInfo = userInfo;
          }else{
            that.WechatLogin();
          }
          console.log("success login");
        },fail(){
          that.WechatLogin();
        }});
    } 
   }
})