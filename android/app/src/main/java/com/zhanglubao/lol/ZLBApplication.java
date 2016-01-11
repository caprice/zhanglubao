package com.zhanglubao.lol;

import android.app.Activity;
import android.app.Application;
import android.content.Context;
import android.content.SharedPreferences;
import android.preference.PreferenceManager;

import com.nostra13.universalimageloader.cache.disc.naming.Md5FileNameGenerator;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.ImageLoaderConfiguration;
import com.nostra13.universalimageloader.core.assist.QueueProcessingType;
import com.zhanglubao.lol.activity.CacheActivity_;
import com.zhanglubao.lol.config.ZLBConfiguration;
import com.zhanglubao.lol.util.Profile;
import com.umeng.fb.push.FeedbackPush;


/**
 * Created by rocks on 14-11-23.
 */
public class ZLBApplication extends Application {

    public static Context mContext;
    public static ImageLoader imageLoader;
    public static SharedPreferences mPref;
    private static final String TAG = ZLBApplication.class.getSimpleName();
    public static ZLBApplication instance;
    public static ZLBConfiguration configuration;
    @Override
    public void onCreate() {
        super.onCreate();
        FeedbackPush.getInstance(this).init(true);
        mContext = this.getApplicationContext();
        mPref = PreferenceManager.getDefaultSharedPreferences(this);
        instance = this;
        initImageLoader(mContext);
        Profile.initProfile("player", ";Android;"
                + android.os.Build.VERSION.RELEASE + ";"
                + android.os.Build.MODEL, mContext);

        configuration = new ZLBConfiguration(this) {
            @Override
            public Class<? extends Activity> getCacheActivityClass() {
                return CacheActivity_.class;
            }

        };

    }

    private static void initImageLoader(Context context) {

        ImageLoaderConfiguration.Builder config = new ImageLoaderConfiguration.Builder(context);
        config.threadPriority(Thread.NORM_PRIORITY - 2);
        config.denyCacheImageMultipleSizesInMemory();
        config.diskCacheFileNameGenerator(new Md5FileNameGenerator());
        config.diskCacheSize(80 * 1024 * 1024); // 50 MiB
        config.tasksProcessingOrder(QueueProcessingType.LIFO);
        ImageLoader.getInstance().init(config.build());
    }







}
