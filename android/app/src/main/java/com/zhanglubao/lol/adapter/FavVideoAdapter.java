package com.zhanglubao.lol.adapter;

import android.content.Context;
import android.graphics.Bitmap;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.nostra13.universalimageloader.core.display.RoundedBitmapDisplayer;
import com.zhanglubao.lol.ZLBApplication;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.activity.FavActivity;
import com.zhanglubao.lol.model.SimpleVideoModel;

import java.util.List;

/**
 * Created by rocks on 15-7-8.
 */
public class FavVideoAdapter extends BaseAdapter {

    List<SimpleVideoModel> videos;
    private LayoutInflater mInflater;
    private DisplayImageOptions options;

    public FavVideoAdapter(Context context, List<SimpleVideoModel> videos) {
        this.videos = videos;
        if (context == null)
            mInflater = LayoutInflater.from(ZLBApplication.mContext);
        else
            mInflater = LayoutInflater.from(context);
        options = new DisplayImageOptions.Builder()
                .showImageOnLoading(R.drawable.default_video_cover)
                .showImageForEmptyUri(R.drawable.default_video_cover)
                .showImageOnFail(R.drawable.default_video_cover)
                .cacheInMemory(true)
                .cacheOnDisk(true)
                .considerExifParams(true)
                .displayer(new RoundedBitmapDisplayer(6))
                .bitmapConfig(Bitmap.Config.RGB_565)
                .build();
    }

    @Override
    public int getCount() {
        return videos.size();
    }

    @Override
    public Object getItem(int position) {
        return videos.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        SimpleVideoModel video = videos.get(position);
        final ViewHolder holder;
        View view = convertView;
        if (view == null) {
            view = mInflater.inflate(R.layout.item_fav, parent, false);
            holder = new ViewHolder();
            holder.imageView = (ImageView) view.findViewById(R.id.favImage);
            holder.titleTextView = (TextView) view.findViewById(R.id.favTitle);
            holder.favEditImgLine = (View) view.findViewById(R.id.favEditImgLine);
            holder.favEditImg = (ImageView) view.findViewById(R.id.favEditImg);

            view.setTag(holder);
        } else {
            holder = (ViewHolder) view.getTag();
        }
        holder.favEditImg.setTag("fav_"+video.getId());
        ImageLoader.getInstance().displayImage(video.getVideo_picture(),
                holder.imageView, options);
        holder.titleTextView.setText(video.getVideo_title());

        if (FavActivity.mIsEditState) {
            holder.favEditImg.setVisibility(View.VISIBLE);
            holder.favEditImg.setImageResource(R.drawable.edit_unselected);

        } else {
            holder.favEditImg.setVisibility(View.GONE);
        }
        return view;
    }



    static class ViewHolder {
        ImageView imageView;
        TextView titleTextView;
        View favEditImgLine;
        ImageView favEditImg;
    }
}
