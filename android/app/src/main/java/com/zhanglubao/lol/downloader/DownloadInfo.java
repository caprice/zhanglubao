package com.zhanglubao.lol.downloader;


import android.app.Notification;
import android.os.Parcel;
import android.os.Parcelable;

import com.zhanglubao.lol.R;
import com.zhanglubao.lol.config.ZLBConfiguration;
import com.zhanglubao.lol.downloader.util.Constants;
import com.zhanglubao.lol.downloader.util.Logger;
import com.zhanglubao.lol.downloader.util.StringUtil;
import com.zhanglubao.lol.util.PlayerUtil;

import org.json.JSONException;
import org.json.JSONObject;

public final class DownloadInfo implements Parcelable, Comparable<DownloadInfo> {

    public final static int STATE_INIT = -1;
    public final static int STATE_DOWNLOADING = 0;
    public final static int STATE_FINISH = 1;
    public final static int STATE_EXCEPTION = 2;
    public final static int STATE_PAUSE = 3;
    public final static int STATE_CANCEL = 4;
    public final static int STATE_WAITING = 5;

    public final static int EXCEPTION_NO_SDCARD = 1;// 无SD卡
    public final static int EXCEPTION_NO_NETWORK = 2;// 无网络
    public final static int EXCEPTION_NO_SPACE = 3;// 无空间
    public final static int EXCEPTION_NO_COPYRIGHT = 4;// 无版权
    public final static int EXCEPTION_NO_RESOURCES = 5;// 无资源
    public final static int EXCEPTION_HTTP_NOT_FOUND = 6;// 网络404错误
    public final static int EXCEPTION_TIMEOUT = 7;// 网络超时
    public final static int EXCEPTION_WRITE_ERROR = 8;// 写入info文件写入错误
    public final static int EXCEPTION_UNKNOWN_ERROR = 9;// 未知错误
    /**
     * 网站高清
     */
    public final static int FORMAT_NORMAL = 1;
    public final static int FORMAT_HIGH = 2;
    public final static int FORMAT_HD = 3;
    public final static int FORMAT_ORGINAL = 4;
    public final static String[] FORMAT_STRINGS = new String[]{"", "mp4",
            "3gp", "ts", "3gphd", "flvhd", "m3u8", "hd2"};
    /**
     * 格式后缀名
     */
    public final static String[] FORMAT_POSTFIX = new String[]{"", "mp4",
            "3gp", "ts", "3gp", "flv", "m3u8", "hd2"};

    /** **************************** 以下为必须字段 ******************************************/

    /**
     * 视频标题
     */
    public String title;
    /**
     * 视频id
     */
    public String videoid;
    /**
     * 视频格式类型：普通、高清等
     */
    public int format;
    /**
     * 语种信息
     */
    public String language;
    /**
     * 剧集id
     */
    public String albumid;
    /**
     * 剧集标题
     */
    public String albumname;
    /**
     * 剧集集数号
     */
    public int album_videoseq;
    /**
     * 剧集总集数
     */
    public int albumepisode_total;
    /**
     * 视频类型
     */
    public String cats;
    /**
     * 视频总时长
     */
    public double seconds;
    /**
     * 每个分片时间
     */
    public double[] segsSeconds;
    /**
     * 视频缓存状态
     */
    public int state = STATE_INIT;

    /** **************************** end ******************************************/

    /** **************************** 下载未完成时的必须字段 ******************************************/

    /**
     * 下载任务id
     */
    public String taskId;
    // /** 文件下载线程 */
    public FileDownloadThread thread;
    /**
     * 该文件的总大小
     */
    public long size;
    /**
     * 速度
     **/
    public String speed = "0K";
    /**
     * 已下载完成的文件的大小
     */
    public long downloadedSize;
    /**
     * 创建时间
     */
    public long createTime;
    /** -------------分片信息---------------- */

    /**
     * 分片总数量
     */
    public int segCount;
    /**
     * 正在缓存的分片id（正在缓存第几个分片）
     */
    public int segId = 1;
    /**
     * 正在缓存的分片地址(这个地址是真实地址，不会过期)
     */
    public String segUrl;
    /**
     * 正在缓存的分片已下载大小
     */
    public long segDownloadedSize;
    /**
     * 每个分片大小（数组）
     */
    public long[] segsSize;
    /**
     * 每个分片地址（数组）（假地址，每次请求起3小时候后过期失效）
     */
    public String[] segsUrl;

    /** **************************** end ******************************************/

    /** **************************** 以下为非必须字段 ******************************************/

    /**
     * 本地已播放时长(单位：秒)
     */
    public int playTime;
    /**
     * 最后播放时间点 (单位：毫秒)
     */
    public long lastPlayTime;
    /**
     * 缩略图地址
     */
    public String imgUrl;
    /**
     * （每次）开始缓存的时间
     */
    public long startTime;
    /**
     * 最后一次获得url的时间
     */
    public long getUrlTime;
    public long finishTime;
    public long lastUpdateTime;
    private int exceptionId;
    public double progress;

    /** -------------内存中信息---------------- */
    /**
     * 保存路径 SD/videoid/
     */
    public String savePath;
    // public DownloadListener downloadInnerListener;// 内部listener，不可调用
    public DownloadListener downloadListener;// 外部listener，可调用
    public Notification notification;
    /**
     * 下载异常后重试次数
     */
    public int retry = 0;
    /**
     * 缩略图是否正在下载中
     */
    public boolean isThumbnailDownloading = false;

    /**
     * *************************** end
     ******************************************/

    public DownloadInfo() {
    }

    protected DownloadInfo(Parcel in) {
        title = in.readString();
        videoid = in.readString();
        format = in.readInt();
        language = in.readString();
        albumid = in.readString();
        albumname = in.readString();
        album_videoseq = in.readInt();
        albumepisode_total = in.readInt();
        cats = in.readString();
        seconds = in.readDouble();
        state = in.readInt();
        taskId = in.readString();
        size = in.readLong();
        downloadedSize = in.readLong();
        createTime = in.readLong();
        segCount = in.readInt();
        speed = in.readString();
        segId = in.readInt();
        segUrl = in.readString();
        segDownloadedSize = in.readLong();
        playTime = in.readInt();
        lastPlayTime = in.readLong();
        imgUrl = in.readString();
        startTime = in.readLong();
        getUrlTime = in.readLong();
        finishTime = in.readLong();
        lastUpdateTime = in.readLong();
        exceptionId = in.readInt();
        progress = in.readDouble();
        savePath = in.readString();
        retry = in.readInt();
        isThumbnailDownloading = in.readByte() != 0x00;
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeString(title);
        dest.writeString(videoid);
        dest.writeInt(format);
        dest.writeString(language);
        dest.writeString(albumid);
        dest.writeString(albumname);
        dest.writeInt(album_videoseq);
        dest.writeInt(albumepisode_total);
        dest.writeString(cats);
        dest.writeDouble(seconds);
        dest.writeInt(state);
        dest.writeString(taskId);
        dest.writeLong(size);
        dest.writeLong(downloadedSize);
        dest.writeLong(createTime);
        dest.writeInt(segCount);
        dest.writeString(speed);
        dest.writeInt(segId);
        dest.writeString(segUrl);
        dest.writeLong(segDownloadedSize);
        dest.writeInt(playTime);
        dest.writeLong(lastPlayTime);
        dest.writeString(imgUrl);
        dest.writeLong(startTime);
        dest.writeLong(getUrlTime);
        dest.writeLong(finishTime);
        dest.writeLong(lastUpdateTime);
        dest.writeInt(exceptionId);
        dest.writeDouble(progress);
        dest.writeString(savePath);
        dest.writeInt(retry);
        dest.writeByte((byte) (isThumbnailDownloading ? 0x01 : 0x00));
    }

    @SuppressWarnings("unused")
    public static final Parcelable.Creator<DownloadInfo> CREATOR = new Parcelable.Creator<DownloadInfo>() {
        @Override
        public DownloadInfo createFromParcel(Parcel in) {
            return new DownloadInfo(in);
        }

        @Override
        public DownloadInfo[] newArray(int size) {
            return new DownloadInfo[size];
        }
    };

    /**
     * TODO Return是否是剧集
     */
    public boolean isSeries() {
        if (albumid == null || albumid.length() == 0)
            return false;
        if (cats == null || cats.length() == 0)
            return true;
        int typeId = getTypeId(cats, albumepisode_total);
        switch (typeId) {
            case Constants.VIDEO_SINGLE:
            case Constants.ALBUM_SINLE:
                return false;
            default:
                break;
        }
        return true;
    }

    /**
     * TODO Comment：视频类型
     *
     * @param type  视频类型
     * @param total 剧集总集数
     * @return
     */
    public static int getTypeId(String type, int total) {
        int typeId = 0;
        if ((ZLBConfiguration.context.getResources().getString(R.string.detail_album))
                .equals(type)) {
            if (total > 1) {
                typeId = Constants.ALBUM_MANY;
            } else {
                typeId = Constants.ALBUM_SINLE;
            }
        } else if ((ZLBConfiguration.context.getResources()
                .getString(R.string.detail_video)).equals(type)) {
            if (total > 1) {
                typeId = Constants.VIDEO_MANY;
            } else {
                typeId = Constants.VIDEO_SINGLE;
            }
        }
        return typeId;
    }

    public void setState(int state) {
        Logger.d("sgh", "download info setState(): " + state);
        if (downloadListener != null)
            Logger.d("sgh", "not null");
        else
            Logger.e("sgh", "null");
        // if (this.state != state) {
        this.state = state;
        switch (state) {
            case STATE_DOWNLOADING:
                if (downloadListener != null)
                    downloadListener.onStart();
                break;
            case STATE_PAUSE:
                if (downloadListener != null)
                    downloadListener.onPause();
                break;
            case STATE_FINISH:
                if (downloadListener != null)
                    downloadListener.onFinish();
                break;
            case STATE_CANCEL:
                if (downloadListener != null)
                    downloadListener.onCancel();
                break;
            case STATE_EXCEPTION:
                if (downloadListener != null)
                    downloadListener.onException();
                break;
            case STATE_WAITING:
                if (downloadListener != null)
                    downloadListener.onWaiting();
                break;
        }
        // }

    }

    public int getState() {
        return state;
    }

    public int getExceptionId() {
        return exceptionId;
    }

    /**
     * TODO 状态是否可能改变
     *
     * @return
     */
    public boolean stateMaybeChange() {
        return state == STATE_DOWNLOADING || state == STATE_WAITING
                || state == STATE_EXCEPTION || state == STATE_PAUSE
                || state == STATE_INIT;
    }

    public double getProgress() {
        if (progress == 0) {
            progress = ((double) downloadedSize * 100) / size;
        }
        return progress;
    }


    public int iseditState;
    public double lastSize;


    public void setProgress() {
        long currentTime = System.currentTimeMillis();
        if (lastSize == 0) {
            lastUpdateTime = currentTime;
            lastSize = this.downloadedSize;
            return;
        }

        if (currentTime - this.lastUpdateTime >= 1000L) {
            this.speed = StringUtil.formatSize2(((float) (this.downloadedSize - lastSize)) / (((float) (currentTime - this.lastUpdateTime)) / 1000L));
            lastSize = this.downloadedSize;
            lastUpdateTime = currentTime;
            this.progress = (((double) (segId - 1)) * 100)
                    / segCount + (((double) 100) / segCount) * (((double) this.segDownloadedSize) / this.segsSize[segId - 1]);

            if (downloadListener != null)
                downloadListener.onProgressChange(progress);
        }

    }


    public void setExceptionId(int exceptionId) {
        this.exceptionId = exceptionId;
    }

    public String getExceptionInfo() {
        return getExceptionInfo(exceptionId);
        // return exceptionInfo;
    }

    public static String getExceptionInfo(int exceptionId) {
        switch (exceptionId) {
            case EXCEPTION_NO_SDCARD:// 无SD卡
                return ZLBConfiguration.context.getString(R.string.download_no_sdcard);
            case EXCEPTION_NO_NETWORK:// 无网络

                return ZLBConfiguration.context.getString(R.string.download_no_network);
            case EXCEPTION_NO_SPACE:// 无空间
                return ZLBConfiguration.context.getString(R.string.download_no_space);
            case EXCEPTION_NO_COPYRIGHT:// 无版权
                return ZLBConfiguration.context.getString(R.string.download_unknown_error);
            case EXCEPTION_NO_RESOURCES:// 无资源
                return ZLBConfiguration.context.getString(R.string.download_unknown_error);
            case EXCEPTION_HTTP_NOT_FOUND:// 网络404错误
                return ZLBConfiguration.context.getString(R.string.download_unknown_error);
            case EXCEPTION_TIMEOUT:// 网络超时
                return ZLBConfiguration.context.getString(R.string.download_timeout);
            case EXCEPTION_WRITE_ERROR:// 写入info文件写入错误
                return ZLBConfiguration.context.getString(R.string.download_write_fail);
            case EXCEPTION_UNKNOWN_ERROR:// 未知错误
                return ZLBConfiguration.context.getString(R.string.download_unknown_error);
            default:
                break;
        }
        return "";
    }

    private static final String KEY_title = "title";
    private static final String KEY_vid = "vid";
    private static final String KEY_albumid = "albumid";
    private static final String KEY_albumname = "albumname";
    private static final String KEY_format = "format";
    private static final String KEY_album_videoseq = "album_videoseq";
    private static final String KEY_albumepisode_total = "albumepisode_total";
    private static final String KEY_cats = "cats";
    private static final String KEY_seconds = "seconds";
    private static final String KEY_size = "size";
    private static final String KEY_segcount = "segcount";
    private static final String KEY_segsseconds = "segsseconds";
    private static final String KEY_segssize = "segssize";
    private static final String KEY_taskid = "taskid";
    private static final String KEY_downloadedsize = "downloadedsize";
    private static final String KEY_segdownloadedsize = "segdownloadedsize";
    private static final String KEY_segID = "segstep";
    private static final String KEY_createtime = "createtime";
    private static final String KEY_starttime = "starttime";
    private static final String KEY_getUrlTime = "getUrlTime";
    private static final String KEY_finishtime = "finishtime";
    // private static final String KEY_segsUrl = "segsUrl";
    private static final String KEY_state = "state";
    private static final String KEY_exceptionid = "exceptionid";
    private static final String KEY_progress = "progress";
    private static final String KEY_language = "language";
    private static final String KEY_playTime = "playTime";
    private static final String KEY_lastPlayTime = "lastPlayTime";
    private static final String KEY_savepath = "savepath";
    private static final String KEY_imgUrl = "imgUrl";

    public JSONObject toJSONObject() {
        JSONObject o = new JSONObject();
        try {
            o.put(KEY_title, title);
            o.put(KEY_vid, videoid);
            o.put(KEY_albumid, albumid);
            o.put(KEY_albumname, albumname);
            o.put(KEY_format, format);
            o.put(KEY_album_videoseq, album_videoseq);
            o.put(KEY_albumepisode_total, albumepisode_total);
            o.put(KEY_cats, cats);
            o.put(KEY_seconds, seconds);
            o.put(KEY_size, size);
            o.put(KEY_segcount, segCount);
            o.put(KEY_segsseconds, PlayerUtil.join(segsSeconds));
            o.put(KEY_segssize, PlayerUtil.join(segsSize));
            o.put(KEY_taskid, taskId);
            o.put(KEY_downloadedsize, downloadedSize);
            o.put(KEY_segdownloadedsize, segDownloadedSize);
            o.put(KEY_segID, segId);
            o.put(KEY_createtime, createTime);
            o.put(KEY_starttime, startTime);
            o.put(KEY_getUrlTime, getUrlTime);
            o.put(KEY_finishtime, finishTime);
            o.put(KEY_state, state);
            o.put(KEY_exceptionid, exceptionId);
            o.put(KEY_progress, progress);
            o.put(KEY_language, language);
            o.put(KEY_playTime, playTime);
            o.put(KEY_lastPlayTime, lastPlayTime);
            o.put(KEY_savepath, savePath);
            o.put(KEY_imgUrl, imgUrl);
        } catch (JSONException e) {
            Logger.e("toJSONObject", e);
            o = null;
        }
        return o;
    }

    public static DownloadInfo jsonToDownloadInfo(String jsonString) {
        JSONObject o;
        try {
            if (jsonString == null || jsonString.length() == 0)
                return null;
            o = new JSONObject(jsonString.trim());
        } catch (JSONException e) {
            Logger.e("Download_DownloadInfo",
                    "DownloadInfo#jsonToDownloadInfo()", e);
            return null;
        }
        DownloadInfo info = new DownloadInfo();
        info.title = o.optString(KEY_title);
        info.videoid = o.optString(KEY_vid);
        info.albumid = o.optString(KEY_albumid);
        info.format = o.optInt(KEY_format);
        info.album_videoseq = o.optInt(KEY_album_videoseq);
        info.albumepisode_total = o.optInt(KEY_albumepisode_total);
        info.cats = o.optString(KEY_cats);
        info.seconds = o.optDouble(KEY_seconds);
        info.size = o.optLong(KEY_size);
        info.segCount = o.optInt(KEY_segcount);
        info.segsSeconds = PlayerUtil.string2double((o.optString(KEY_segsseconds))
                .split(","));
        info.segsSize = PlayerUtil.string2long(o.optString(KEY_segssize).split(
                ","));
        info.taskId = o.optString(KEY_taskid);
        info.downloadedSize = o.optInt(KEY_downloadedsize);
        info.segDownloadedSize = o.optInt(KEY_segdownloadedsize);
        info.segId = o.optInt(KEY_segID, 1);
        info.createTime = o.optLong(KEY_createtime);
        info.startTime = o.optLong(KEY_starttime);
        info.getUrlTime = o.optLong(KEY_getUrlTime);
        info.finishTime = o.optLong(KEY_finishtime);
        info.state = o.optInt(KEY_state, STATE_INIT);
        info.exceptionId = o.optInt(KEY_exceptionid);
        info.progress = o.optDouble(KEY_progress, 0);
        info.language = o.optString(KEY_language);
        info.playTime = o.optInt(KEY_playTime);
        info.lastPlayTime = o.optLong(KEY_lastPlayTime);
        info.albumname = o.optString(KEY_albumname);
        info.savePath = o.optString(KEY_savepath);
        info.imgUrl = o.optString(KEY_imgUrl);
        return info;
    }

    public String getProgressJSONFile() {
        JSONObject o = new JSONObject();
        try {
            o.put(KEY_downloadedsize, downloadedSize);
            o.put(KEY_segdownloadedsize, segDownloadedSize);
            o.put(KEY_segID, segId);
            o.put(KEY_progress, progress);
        } catch (JSONException e) {
            Logger.e("toJSONObject", e);
            return null;
        }
        return o.toString();
    }

    public static DownloadInfo parseProgressJSONFile(String jsonString) {
        JSONObject o;
        try {
            if (jsonString == null || jsonString.length() == 0)
                return null;
            o = new JSONObject(jsonString.trim());
        } catch (JSONException e) {
            Logger.e("jsonToDownloadInfo", e);
            return null;
        }
        DownloadInfo info = new DownloadInfo();
        info.downloadedSize = o.optInt(KEY_downloadedsize);
        info.segDownloadedSize = o.optInt(KEY_segdownloadedsize);
        info.segId = o.optInt(KEY_segID, 1);
        info.progress = o.optDouble(KEY_progress, 0);
        return info;
    }

    /**
     * 是否按剧集排序，true按剧集排序；false按时间排序
     */
    public static boolean compareBySeq = true;

    @Override
    public int compareTo(DownloadInfo info) {

        if (compareBySeq) {
            if (this.album_videoseq > info.album_videoseq) {
                return 1;
            } else {
                return -1;
            }
        } else {
            if (this.createTime > info.createTime) {
                return 1;
            } else {
                return -1;
            }
        }

    }

    @Override
    public String toString() {
        JSONObject o = toJSONObject();
        return o == null ? "" : o.toString();
    }
}