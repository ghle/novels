var app = getApp()
var https = require('../../utils/https.js')

Page({
  data: {
    height: 20,
    focus: true,
    hasReq:false
  },
  formSubmit: function (e) {
    console.log(e);
    var that=this;
    if (e.detail.value.feedcontent){
      var url = app.globalData.feedbackUrl + `?feedcontent=${e.detail.value.feedcontent}` + `&feedtitle=${e.detail.value.feedtitle}`;
      
      if (that.data.hasReq==true){
         return;
      }
      that.setData({
        hasReq: true
      })
      https.get(url,
        function (res) {
          console.log(res);
          that.setData({
            hasReq: false
          })
          wx.showModal({
            title: '',
            content: '提交成功',
            showCancel: false,
            success:function(){
             
              wx.switchTab({
                url: '../user/user',
              })

            }
          })
           
        }, function (res) {
          that.setData({
            hasReq: false
          })
          wx.showModal({
            title: '',
            content: '提交失败',
            showCancel: false,
          })
        });
    }
  }
})