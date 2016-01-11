package com.zhanglubao.lol.adapter;

import android.content.Context;
import android.graphics.drawable.Drawable;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.zhanglubao.lol.R;
import com.zhanglubao.lol.config.ZLBConfiguration;
import com.zhanglubao.lol.downloader.AsyncImageLoader;
import com.zhanglubao.lol.downloader.BaseDownload;
import com.zhanglubao.lol.downloader.DownloadInfo;
import com.zhanglubao.lol.fragment.CachedFragment;

import java.text.DecimalFormat;
import java.util.ArrayList;

/**
 * Created by rocks on 15-7-1.
 */
public class CachedVideoAdapter extends BaseAdapter {

    private LayoutInflater mInflater;
    private ArrayList<DownloadInfo> downloadinfoList;
    private AsyncImageLoader loader;

    /**
     * 是否可编辑的
     */
    public CachedVideoAdapter(Context context,
                               ArrayList<DownloadInfo> downloadinfoList) {
        if (context == null)
            mInflater = LayoutInflater.from(ZLBConfiguration.context);
        else
            mInflater = LayoutInflater.from(context);
        this.downloadinfoList = downloadinfoList;
        loader = AsyncImageLoader.getInstance();
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
        return downloadinfoList.get(position);
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
            convertView = mInflater.inflate(R.layout.item_video_downloaded, null);
            viewHolder = new ViewHolder();
            viewHolder.thumbnail = (ImageView) convertView
                    .findViewById(R.id.cacheImage);
            viewHolder.title = (TextView) convertView.findViewById(R.id.cacheTitle);
            viewHolder.size=(TextView)convertView.findViewById(R.id.cacheSize);
            viewHolder.editImg=(ImageView)convertView.findViewById(R.id.cacheEditImg);
            viewHolder.editImgLine=(View)convertView.findViewById(R.id.cacheEditImgLine);
            convertView.setTag(viewHolder);
        } else {
            viewHolder = (ViewHolder) convertView.getTag();
        }

        final DownloadInfo info = downloadinfoList.get(position);
        viewHolder.title.setText(info.title);
        Drawable d = loader.loadDrawable(viewHolder.thumbnail, info.imgUrl,
                info.savePath + BaseDownload.THUMBNAIL_NAME, info);
        if (d == null) {
            viewHolder.thumbnail.setBackgroundDrawable(null);
        } else {
            viewHolder.thumbnail.setBackgroundDrawable(d);
        }
        viewHolder.size.setText("高清"+df.format(info.size / (1024 * 1024))+" MB");

        viewHolder.editImg.setTag("cached_" + info.videoid);

        if (CachedFragment.mIsEditState) {
            viewHolder.editImg.setVisibility(View.VISIBLE);
            viewHolder.editImg.setImageResource(R.drawable.edit_unselected);
        } else {
            viewHolder.editImg.setVisibility(View.GONE);
        }

        return convertView;
    }


    /**
     * 格式化对象
     */
    private final DecimalFormat df = new DecimalFormat("0.#");

    class ViewHolder {
        private ImageView thumbnail;
        private TextView title;
        private  TextView size;
        View editImgLine;
        ImageView editImg;
    }
}

