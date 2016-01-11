package com.zhanglubao.lol.view.player;

import android.content.Context;
import android.os.PowerManager;
import android.util.AttributeSet;
import android.view.Display;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;

import com.alibaba.fastjson.JSON;
import com.loopj.android.http.RequestParams;
import com.loopj.android.http.TextHttpResponseHandler;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.downloader.DownloadInfo;
import com.zhanglubao.lol.model.SimpleVideoModel;
import com.zhanglubao.lol.network.QTApi;
import com.zhanglubao.lol.network.QTClient;
import com.zhanglubao.lol.network.entity.SniffEntity;
import com.zhanglubao.lol.util.Orientation;
import com.zhanglubao.lol.util.VideoUtil;

import org.apache.http.Header;

import io.vov.vitamio.MediaPlayer;
import io.vov.vitamio.widget.MediaController;
import io.vov.vitamio.widget.VideoView;


/**
 * Created by rocks on 15-6-3.
 */
public class QTPlayerView extends RelativeLayout implements MediaController.MediaPlayerControl, MediaPlayer.OnCompletionListener, MediaPlayer.OnErrorListener, MediaPlayer.OnInfoListener, MediaPlayer.OnPreparedListener {

    VideoView videoView;
    QTController qtController;
    ImageView playButton;
    ImageView videoCover;
    ProgressBar progressBar;


    PowerManager.WakeLock wakeLock;
    Context context;
    SimpleVideoModel videoModel;
    SniffEntity sniffEntity;
    private static final int sDefaultTimeout = 3000;

    public Orientation currentOriention;

    private MediaPlayer.OnPreparedListener preparedListener;
    private MediaPlayer.OnCompletionListener completionListener;
    private MediaPlayer.OnErrorListener errorListener;


    public QTPlayerView(Context context) {
        super(context);
    }

    public QTPlayerView(Context context, AttributeSet attrs) {
        super(context, attrs);
        this.context = context;
        LayoutInflater.from(context).inflate(R.layout.view_video_view, this, true);


    }

    @Override
    protected void onFinishInflate() {
        super.onFinishInflate();
        wakeLock = ((PowerManager) getContext().getSystemService("power")).newWakeLock(PowerManager.SCREEN_DIM_WAKE_LOCK, "QTVideoPlayer");
        videoView = (VideoView) findViewById(R.id.widget_video_view);
        qtController = (QTController) findViewById(R.id.widget_media_controller);

        videoCover = (ImageView) findViewById(R.id.widget_video_cover);
        progressBar = (ProgressBar) findViewById(R.id.widget_loading_indicator);
        videoView.setOnTouchListener(new OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                qtController.show(sDefaultTimeout);
                return true;
            }
        });


    }

    //获取屏幕的宽度
    public static int getScreenWidth(Context context) {
        WindowManager manager = (WindowManager) context
                .getSystemService(Context.WINDOW_SERVICE);
        Display display = manager.getDefaultDisplay();
        return display.getWidth();
    }


    public void setVideoModel(SimpleVideoModel simpleVideoModel) {
        this.videoModel = simpleVideoModel;
        progressBar.setVisibility(View.VISIBLE);
        qtController.setTitle(simpleVideoModel.getVideo_title());
        getData();

    }

    public void getData() {
        QTApi.sniff(videoModel.getId(), new TextHttpResponseHandler() {


            @Override
            public void onSuccess(int i, Header[] headers, String response) {
                try {
                    sniffEntity = (SniffEntity) JSON.parseObject(response, SniffEntity.class);
                    receiveData(sniffEntity);
                } catch (Exception e) {

                    receiveError();
                }
            }

            @Override
            public void onFailure(int i, Header[] headers, String response, Throwable throwable) {
                receiveError();
            }
        });
    }

    public void receiveError() {

    }

    public void receiveData(SniffEntity sniffEntity) {
        getUrl(sniffEntity);

    }

    public void getUrl(SniffEntity sniffEntity) {
        RequestParams requestParams=new RequestParams();
        QTClient.directGet(sniffEntity.getHd().getUrl(),requestParams, new TextHttpResponseHandler() {
            @Override
            public void onFailure(int i, Header[] headers, String s, Throwable throwable) {
                String result = s;
                receiveError();
            }

            @Override
            public void onSuccess(int i, Header[] headers, String result) {
                decode(result);

            }
        });

    }

    private void decode(String content) {
        String url = VideoUtil.parse(content);
        setUrl(url);
    }


    public void setUrl(String url) {

        this.videoView.setOnPreparedListener(this);
        this.videoView.setOnCompletionListener(this);
        this.videoView.setOnErrorListener(this);
        this.videoView.setOnInfoListener(this);
        this.videoView.setVideoPath(url);
        qtController.setMediaPlayer(this);
    }

    public void playLocal(DownloadInfo info) {
        progressBar.setVisibility(View.VISIBLE);
        this.videoView.setOnPreparedListener(this);
        this.videoView.setOnCompletionListener(this);
        this.videoView.setOnErrorListener(this);
        this.videoView.setOnInfoListener(this);
        qtController.setMediaPlayer(this);
        qtController.setTitle(info.title);
        String path = info.savePath + "zhanglubao.m3u8";
        this.videoView.setVideoPath(path);
    }

    @Override
    public boolean onTouchEvent(MotionEvent event) {
        qtController.show(sDefaultTimeout);
        return true;
    }

    @Override
    public boolean onTrackballEvent(MotionEvent ev) {
        qtController.show(sDefaultTimeout);
        return false;
    }


    @Override
    public void start() {
        if (videoView != null && !videoView.isPlaying()) {
            videoView.start();
        }
    }

    @Override
    public void pause() {
        if (videoView != null && videoView.isPlaying()) {
            videoView.pause();
        }
    }

    @Override
    public long getDuration() {
        return this.videoView.getDuration();
    }

    @Override
    public long getCurrentPosition() {
        return this.videoView.getCurrentPosition();
    }

    @Override
    public void seekTo(long pos) {
        videoView.seekTo(pos);
    }

    @Override
    public boolean isPlaying() {
        return videoView.isPlaying();

    }

    @Override
    public int getBufferPercentage() {
        return videoView.getBufferPercentage();
    }


    @Override
    public void onCompletion(MediaPlayer mp) {
        if ((this.wakeLock != null) && (this.wakeLock.isHeld()))
            this.wakeLock.release();
    }

    @Override
    public boolean onError(MediaPlayer mp, int what, int extra) {
        return false;
    }

    @Override
    public boolean onInfo(MediaPlayer mp, int what, int extra) {
        return false;
    }

    @Override
    public void onPrepared(MediaPlayer mp) {
        videoCover.setVisibility(View.GONE);
        progressBar.setVisibility(View.GONE);
        if ((this.wakeLock != null) && (!this.wakeLock.isHeld())) {
            wakeLock.acquire();
        }
        qtController.show(0);

    }


    public void setOnCompletionListener(MediaPlayer.OnCompletionListener onCompletionListener) {
        this.completionListener = onCompletionListener;
    }

    public void setOnErrorListener(MediaPlayer.OnErrorListener onErrorListener) {
        this.errorListener = onErrorListener;
    }

    public void setOnPreparedListener(MediaPlayer.OnPreparedListener onPreparedListener) {
        this.preparedListener = onPreparedListener;
    }

    /**
     * 设置竖屏布局
     */
    public void setVerticalLayout()// 设置竖屏布局
    {
        this.setLayoutParams(new LinearLayout.LayoutParams(
                LinearLayout.LayoutParams.MATCH_PARENT,
                LinearLayout.LayoutParams.WRAP_CONTENT));

        hideBottonInteract();
    }

    /**
     * 隐藏pad横屏下的交互区
     */
    private void hideBottonInteract() {

    }


    public void setFullscreenBack() {
        this.setLayoutParams(new RelativeLayout.LayoutParams(
                RelativeLayout.LayoutParams.MATCH_PARENT,
                RelativeLayout.LayoutParams.MATCH_PARENT));
        videoView.setVideoLayout(1, 0);
    }
}
