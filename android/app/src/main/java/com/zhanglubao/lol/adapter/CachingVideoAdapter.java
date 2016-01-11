package com.zhanglubao.lol.adapter;

import android.content.Context;
import android.graphics.drawable.Drawable;
import android.os.Handler;
import android.os.Message;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

import com.zhanglubao.lol.R;
import com.zhanglubao.lol.config.ZLBConfiguration;
import com.zhanglubao.lol.downloader.AsyncImageLoader;
import com.zhanglubao.lol.downloader.BaseDownload;
import com.zhanglubao.lol.downloader.DownloadInfo;
import com.zhanglubao.lol.fragment.CachingFragment_;
import com.zhanglubao.lol.view.widget.RoundProgressBar;

import java.text.DecimalFormat;
import java.util.ArrayList;

/**
 * Created by rocks on 15-7-1.
 */
public class CachingVideoAdapter extends BaseAdapter {

    private LayoutInflater mInflater;
    private ArrayList<DownloadInfo> downloadinfoList;
    private ListView listView;
    private AsyncImageLoader loader;

    /**
     * 是否可编辑的
     */
    public CachingVideoAdapter(Context context,
                               ArrayList<DownloadInfo> downloadinfoList, ListView listView) {
        if (context == null)
            mInflater = LayoutInflater.from(ZLBConfiguration.context);
        else
            mInflater = LayoutInflater.from(context);
        this.downloadinfoList = downloadinfoList;
        loader = AsyncImageLoader.getInstance();
        this.listView = listView;
    }

    public void setUpdate(DownloadInfo info) {
        Message message = Message.obtain();
        message.obj = info;
        handler.sendMessage(message);
    }

    /**
     * 重新装载数据
     */
    public void setData(ArrayList<DownloadInfo> downloadinfoList) {
        this.downloadinfoList = downloadinfoList;
    }


    @Override
    public int getCount() {
        if (downloadinfoList != null)
            return downloadinfoList.size();
        return 0;
    }

    @Override
    public Object getItem(int position) {
        return position;
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @SuppressWarnings("deprecation")
    @Override
    public View getView(final int position, View convertView, ViewGroup parent) {
        if (position > downloadinfoList.size() - 1)
            return null;
        final ViewHolder viewHolder;
        if (convertView == null) {
            convertView = mInflater.inflate(R.layout.item_video_downloading, null);
            viewHolder = new ViewHolder();
            viewHolder.thumbnail = (ImageView) convertView
                    .findViewById(R.id.cacheImage);
            viewHolder.title = (TextView) convertView.findViewById(R.id.cacheTitle);
            viewHolder.progressBar = (RoundProgressBar) convertView.findViewById(R.id.roundProgressBar);
            viewHolder.speed = (TextView) convertView.findViewById(R.id.cacheSpeed);
            viewHolder.size = (TextView) convertView.findViewById(R.id.cacheSize);
            viewHolder.statusImg = (ImageView) convertView.findViewById(R.id.cacheStatusImg);
            viewHolder.editImg = (ImageView) convertView.findViewById(R.id.cacheEditImg);
            viewHolder.editImgLine = (View) convertView.findViewById(R.id.cacheEditImgLine);
            convertView.setTag(viewHolder);
        } else {
            viewHolder = (ViewHolder) convertView.getTag();
        }

        final DownloadInfo info = downloadinfoList.get(position);
        viewHolder.speed.setTag("progressTextView" + info.videoid);
        viewHolder.statusImg.setTag("statusImageView" + info.videoid);
        viewHolder.progressBar.setTag("progressRoundProgressBar" + info.videoid);
        viewHolder.title.setText(info.title);
        viewHolder.progressBar.setProgress((int) info.getProgress());
        Drawable d = loader.loadDrawable(viewHolder.thumbnail, info.imgUrl,
                info.savePath + BaseDownload.THUMBNAIL_NAME, info);
        if (d == null) {
            viewHolder.thumbnail.setBackgroundDrawable(null);
        } else {
            viewHolder.thumbnail.setBackgroundDrawable(d);
        }
        viewHolder.size.setText("高清" + df.format(info.size / (1024 * 1024)) + " MB");

        viewHolder.editImg.setTag("caching_" + info.videoid);
        if (CachingFragment_.mIsEditState) {
            viewHolder.editImg.setVisibility(View.VISIBLE);
            viewHolder.editImg.setImageResource(R.drawable.edit_unselected);
        } else {
            viewHolder.editImg.setVisibility(View.GONE);
        }
        return convertView;
    }


    class ViewHolder {
        private ImageView thumbnail;
        private TextView title;
        private TextView speed;
        private TextView size;
        private ImageView statusImg;
        private RoundProgressBar progressBar;
        private View editImgLine;
        private ImageView editImg;
    }


    /**
     * 设置更新状态的改变
     */
    private void setStateChange(TextView state, RoundProgressBar progress, ImageView statusImageView,
                                DownloadInfo info) {
        switch (info.getState()) {
            case DownloadInfo.STATE_DOWNLOADING:
                progress.setVisibility(View.VISIBLE);
                statusImageView.setVisibility(View.GONE);
                state.setText(info.speed + "/S");
                progress.setProgress((int) info.progress);
                break;
            case DownloadInfo.STATE_PAUSE:
                state.setText(R.string.pause);
                progress.setVisibility(View.GONE);
                statusImageView.setVisibility(View.VISIBLE);
                statusImageView.setImageResource(R.drawable.btn_stop);
                progress.setProgress((int) info.progress);
                break;
            case DownloadInfo.STATE_INIT:
            case DownloadInfo.STATE_WAITING:
            case DownloadInfo.STATE_EXCEPTION:
                state.setText(R.string.wait);
                progress.setVisibility(View.GONE);
                statusImageView.setVisibility(View.VISIBLE);
                statusImageView.setImageResource(R.drawable.btn_wait);
                progress.setProgress((int) info.progress);
                break;
        }
    }

    /**
     * 格式化对象
     */
    private final DecimalFormat df = new DecimalFormat("0.#");

    /**
     * 得到下载大小 例如26M/60M
     */
    private String getProgress(DownloadInfo info) {
        final String totalSize = df.format(info.size / (1024 * 1024));
        final String downloadedSize = df.format(info.downloadedSize
                / (1024 * 1024));
        return downloadedSize + "M/" + totalSize + "M";
    }

    private Handler handler = new Handler() {
        public void handleMessage(Message msg) {
            DownloadInfo info = (DownloadInfo) msg.obj;
            TextView speedText = (TextView) listView
                    .findViewWithTag("progressTextView" + info.videoid);
            RoundProgressBar roundProgressBar = (RoundProgressBar) listView
                    .findViewWithTag("progressRoundProgressBar" + info.videoid);
            ImageView statusImg = (ImageView) listView.findViewWithTag("statusImageView" + info.videoid);
            if (speedText == null || roundProgressBar == null)
                return;
            setStateChange(speedText, roundProgressBar, statusImg, info);
        }
    };


}