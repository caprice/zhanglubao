package com.zhanglubao.lol.adapter;

import android.content.Context;
import android.content.Intent;
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
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.activity.VideoDetailActivity_;
import com.zhanglubao.lol.model.SimpleVideoModel;
import com.zhanglubao.lol.util.NetworkUtils;

import java.util.List;

/**
 * Created by rocks on 15-5-30.
 */
public class SimpleVideoAdapter extends BaseAdapter {
    List<SimpleVideoModel> videos;
    Context context;


    private DisplayImageOptions options;
    private LayoutInflater inflater;

    public SimpleVideoAdapter(Context context, List<SimpleVideoModel> videos) {
        this.context = context;
        this.videos = videos;
        inflater = LayoutInflater.from(context);

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
            view = inflater.inflate(R.layout.item_video_simple_grid, parent, false);
            holder = new ViewHolder();
            holder.imageView = (ImageView) view.findViewById(R.id.itemImage);
            holder.titleTextView = (TextView) view.findViewById(R.id.itemText);
            view.setTag(holder);
        } else {
            holder = (ViewHolder) view.getTag();
        }

        ImageLoader.getInstance().displayImage(video.getVideo_picture(),
                holder.imageView, options);
        holder.titleTextView.setText(video.getVideo_title());
        view.setOnClickListener(new ItemClickListener(video));
        return view;
    }

    static class ViewHolder {
        ImageView imageView;
        TextView titleTextView;
    }

    class ItemClickListener implements  View.OnClickListener
    {
        SimpleVideoModel videoModel;

        public ItemClickListener(SimpleVideoModel videoModel) {
            this.videoModel = videoModel;
        }

        @Override
        public void onClick(View v) {
            if (NetworkUtils.isNetworkAvailable()) {
                Intent intent = new Intent(context, VideoDetailActivity_.class);
                intent.putExtra("video", videoModel);
                context.startActivity(intent);
            }
        }
    }
}
