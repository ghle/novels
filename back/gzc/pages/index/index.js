var app = getApp()
var https = require('../../utils/https.js')

Page({
  data: {
    // text:"这是一个页面"
    list: [],
    indexrecommend:[],
    windowHeight: 0,//获取屏幕高度  
  },
  onLoad: function (options) {


    var that = this;
    that.indexrecommend(),

    //获取屏幕高度  
    wx.getSystemInfo({
      success: function (res) {
    
        that.setData({
          windowHeight: res.windowHeight,
          
        })
      }
    })
    try{
      var value = wx.getStorageSync('cateList')
      // console.log(value);
      if(value){
        that.setData({
          list: value,
        });
      }else{
        var url = app.globalData.categoryUrl;
        https.get(url,
          function (res) {
            console.log(res);
            that.setData({
              list: res.data,
            });
            wx.setStorage({
              key: "cateList",
              data: res.data
            })
            wx.setStorage({
              key: "cateListTime",
              data: new Date((new Date() / 1000 + 86400) * 1000).getTime()
            })
          }, function (res) {
            console.log(res);
          });
      }
    } catch (e){
    }






  },
  toList:function(e){
    
    wx.navigateTo({
      url: `../list/list?bpid=${e.currentTarget.dataset.cat}`
    });
  },

  indexrecommend: function () {
    var that=this;
    var url = app.globalData.indexrecommend;
    https.get(url,
      function (res) {
     
        that.setData({
          indexrecommend: res.data,
        })
      })
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
  //点击事件处理
  bindViewTap: function (e) {
    console.log(e.currentTarget.dataset.id);
  },
  //点击事件处理
  clickDetail: function (e) {

    wx.navigateTo({
      url: `../detail/detail?id=${e.currentTarget.id}`
    });
  },
})