package com.zhanglubao.lol.activity;

import android.content.pm.ActivityInfo;
import android.os.Bundle;

import com.loopj.android.http.TextHttpResponseHandler;
import com.umeng.socialize.bean.SHARE_MEDIA;
import com.umeng.socialize.controller.UMServiceFactory;
import com.umeng.socialize.controller.UMSocialService;
import com.umeng.socialize.facebook.controller.UMFacebookHandler;
import com.umeng.socialize.facebook.media.FaceBookShareContent;
import com.umeng.socialize.media.MailShareContent;
import com.umeng.socialize.media.QQShareContent;
import com.umeng.socialize.media.QZoneShareContent;
import com.umeng.socialize.media.SinaShareContent;
import com.umeng.socialize.media.SmsShareContent;
import com.umeng.socialize.media.TencentWbShareContent;
import com.umeng.socialize.media.TwitterShareContent;
import com.umeng.socialize.media.UMImage;
import com.umeng.socialize.sso.EmailHandler;
import com.umeng.socialize.sso.QZoneSsoHandler;
import com.umeng.socialize.sso.SinaSsoHandler;
import com.umeng.socialize.sso.SmsHandler;
import com.umeng.socialize.sso.UMQQSsoHandler;
import com.umeng.socialize.weixin.controller.UMWXHandler;
import com.umeng.socialize.weixin.media.CircleShareContent;
import com.umeng.socialize.weixin.media.WeiXinShareContent;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.downloader.DownloadInfo;
import com.zhanglubao.lol.evenbus.UnVideoFavEvent;
import com.zhanglubao.lol.evenbus.VideoFavEvent;
import com.zhanglubao.lol.evenbus.VideoShareEvent;
import com.zhanglubao.lol.network.QTApi;
import com.zhanglubao.lol.network.QTUrl;
import com.zhanglubao.lol.util.PlayerUtil;
import com.zhanglubao.lol.util.UmengUtil;
import com.zhanglubao.lol.view.player.QTPlayerView;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.EActivity;
import org.androidannotations.annotations.Extra;
import org.androidannotations.annotations.ViewById;
import org.apache.http.Header;

import io.vov.vitamio.Vitamio;


/**
 * Created by rocks on 15-7-1.
 */
@EActivity(R.layout.activity_player)
public class PlayerActivity extends BaseFragmentActivity {

    @Extra("info")
    DownloadInfo info;


    @ViewById(R.id.video_view)
    QTPlayerView qtPlayerView;

    //share
    final UMSocialService mController = UMServiceFactory.getUMSocialService("com.umeng.share");
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        isFull=false;
        super.onCreate(savedInstanceState);
        Vitamio.isInitialized(this);

    }
    @AfterViews
    public void afterView() {
        addShareConfig();
        setShareContent();
        qtPlayerView.playLocal(info);
    }

    @Override
    protected void onResume() {
        super.onResume();
        setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE);
    }




    public void onEvent(VideoShareEvent event) {


        mController.getConfig().setPlatforms(SHARE_MEDIA.QQ,SHARE_MEDIA.SINA,SHARE_MEDIA.WEIXIN, SHARE_MEDIA.WEIXIN_CIRCLE,
                SHARE_MEDIA.QZONE,    SHARE_MEDIA.TWITTER,SHARE_MEDIA.SMS,SHARE_MEDIA.EMAIL
        );
        mController.openShare(this, false);
    }

    public void addShareConfig() {
        addWXPlatform();
        addQQQZonePlatform();
        addEmail();
        addSMS();
    }

    /**
     * @return
     * @功能描述 : 添加微信平台分享
     */
    private void addWXPlatform() {
        // 注意：在微信授权的时候，必须传递appSecret
        // wx967daebe835fbeac是你在微信开发平台注册应用的AppID, 这里需要替换成你注册的AppID
        String appId = UmengUtil.WX_APP_ID;
        String appSecret = UmengUtil.WX_APP_SEC;
        // 添加微信平台
        UMWXHandler wxHandler = new UMWXHandler(this, appId, appSecret);
        wxHandler.addToSocialSDK();

        // 支持微信朋友圈
        UMWXHandler wxCircleHandler = new UMWXHandler(this, appId, appSecret);
        wxCircleHandler.setToCircle(true);
        wxCircleHandler.addToSocialSDK();
    }

    /**
     * @return
     * @功能描述 : 添加QQ平台支持 QQ分享的内容， 包含四种类型， 即单纯的文字、图片、音乐、视频. 参数说明 : title, summary,
     * image url中必须至少设置一个, targetUrl必须设置,网页地址必须以"http://"开头 . title :
     * 要分享标题 summary : 要分享的文字概述 image url : 图片地址 [以上三个参数至少填写一个] targetUrl
     * : 用户点击该分享时跳转到的目标地址 [必填] ( 若不填写则默认设置为友盟主页 )
     */
    private void addQQQZonePlatform() {
        String appId = UmengUtil.QQ_APP_ID;
        String appKey = UmengUtil.QQ_APP_KEY;
        // 添加QQ支持, 并且设置QQ分享内容的target url
        UMQQSsoHandler qqSsoHandler = new UMQQSsoHandler(this,
                appId, appKey);
        qqSsoHandler.setTargetUrl("http://www.zhanglubao.com/");
        qqSsoHandler.addToSocialSDK();

        // 添加QZone平台
        QZoneSsoHandler qZoneSsoHandler = new QZoneSsoHandler(this, appId, appKey);
        qZoneSsoHandler.addToSocialSDK();
    }

    /**
     * @throws
     * @Title: addFacebook
     * @Description:
     */
    private void addFacebook() {

        UMFacebookHandler mFacebookHandler = new UMFacebookHandler(this);
        mFacebookHandler.addToSocialSDK();
        FaceBookShareContent fbContent = new FaceBookShareContent();

        fbContent.setTitle(info.title);
        fbContent.setCaption(info.title);
        fbContent.setShareContent(info.title);
        fbContent.setTargetUrl(QTUrl.getVideoFrom(info.videoid));
        mController.setShareMedia(fbContent);

    }

    /**
     * 添加短信平台</br>
     */
    private void addSMS() {
        // 添加短信
        SmsHandler smsHandler = new SmsHandler();
        smsHandler.addToSocialSDK();
    }

    /**
     * 添加Email平台</br>
     */
    private void addEmail() {
        // 添加email
        EmailHandler emailHandler = new EmailHandler();
        emailHandler.addToSocialSDK();
    }

    public void setShareContent() {

        String title = info.title;
        String picture = info.imgUrl;
        String from = QTUrl.getVideoFrom(info.videoid);
        String content = info.title + " " + from;

        // 配置SSO
        mController.getConfig().setSsoHandler(new SinaSsoHandler());

        QZoneSsoHandler qZoneSsoHandler = new QZoneSsoHandler(this,
                UmengUtil.QQ_APP_ID, UmengUtil.QQ_APP_KEY);
        qZoneSsoHandler.addToSocialSDK();
        mController.setShareContent(info.title + " " + from);

        UMImage urlImage = new UMImage(this, info.imgUrl);


        WeiXinShareContent weixinContent = new WeiXinShareContent();
        weixinContent
                .setShareContent(content);
        weixinContent.setTitle(title);
        weixinContent.setTargetUrl(from);
        weixinContent.setShareMedia(urlImage);
        mController.setShareMedia(weixinContent);

        // 设置朋友圈分享的内容
        CircleShareContent circleMedia = new CircleShareContent();
        circleMedia
                .setShareContent(content);
        circleMedia.setTitle(title);
        circleMedia.setShareMedia(urlImage);

        circleMedia.setTargetUrl(from);
        mController.setShareMedia(circleMedia);


        UMImage qzoneImage = new UMImage(this, picture);
        qzoneImage
                .setTargetUrl(picture);

        // 设置QQ空间分享内容
        QZoneShareContent qzone = new QZoneShareContent();
        qzone.setShareContent(content);
        qzone.setTargetUrl(from);
        qzone.setTitle(title);
        qzone.setShareMedia(urlImage);
        mController.setShareMedia(qzone);


        QQShareContent qqShareContent = new QQShareContent();
        qqShareContent.setShareContent(content);
        qqShareContent.setTitle(title);
        qqShareContent.setTargetUrl(from);
        qqShareContent.setShareImage(urlImage);
        mController.setShareMedia(qqShareContent);


        TencentWbShareContent tencent = new TencentWbShareContent();
        tencent.setShareContent(content);
        tencent.setTargetUrl(from);
        tencent.setShareImage(urlImage);
        // 设置tencent分享内容
        mController.setShareMedia(tencent);

        // 设置邮件分享内容， 如果需要分享图片则只支持本地图片
        MailShareContent mail = new MailShareContent();
        mail.setTitle(title);
        mail.setShareContent(content);
        // 设置tencent分享内容
        mController.setShareMedia(mail);

        // 设置短信分享内容
        SmsShareContent sms = new SmsShareContent();
        sms.setShareContent(content);
        // sms.setShareImage(urlImage);
        mController.setShareMedia(sms);

        SinaShareContent sinaContent = new SinaShareContent();
        sinaContent
                .setShareContent(content);
        sinaContent.setTargetUrl(from);
        sinaContent.setShareImage(urlImage);
        mController.setShareMedia(sinaContent);

        TwitterShareContent twitterShareContent = new TwitterShareContent();
        twitterShareContent
                .setShareContent(content);
        mController.setShareMedia(twitterShareContent);


    }
    public void onEvent(VideoFavEvent event) {

        QTApi.fav(info.videoid, new TextHttpResponseHandler() {
            @Override
            public void onFailure(int i, Header[] headers, String s, Throwable throwable) {

                PlayerUtil.showTips(R.string.fav_fail);

            }

            @Override
            public void onSuccess(int i, Header[] headers, String s) {
                PlayerUtil.showTips(R.string.fav_success);
            }
        });

    }

    public void onEvent(UnVideoFavEvent event) {
        String[] videoids = {info.videoid};
        QTApi.unfav(videoids, new TextHttpResponseHandler() {
            @Override
            public void onFailure(int i, Header[] headers, String s, Throwable throwable) {

                PlayerUtil.showTips(R.string.unfav_fail);

            }

            @Override
            public void onSuccess(int i, Header[] headers, String s) {
                PlayerUtil.showTips(R.string.unfav_success);
            }
        });
    }

    @Override
    public void onDestroy() {
        super.onDestroy();

    }

}
