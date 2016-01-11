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
import com.zhanglubao.lol.activity.VideoGridActivity_;
import com.zhanglubao.lol.model.SimpleAlbumModel;
import com.zhanglubao.lol.network.QTUrl;

import java.util.List;

/**
 * Created by rocks on 15-5-31.
 */
public class SimpleAlbumAdapter extends BaseAdapter {
    List<SimpleAlbumModel> albums;
    Context context;

    private ImageLoader imageLoader;
    private DisplayImageOptions options;
    private LayoutInflater inflater;

    public SimpleAlbumAdapter(Context context, List<SimpleAlbumModel> albums) {
        this.context = context;
        this.albums = albums;
        inflater = LayoutInflater.from(context);
        imageLoader = ImageLoader.getInstance();
        options = new DisplayImageOptions.Builder()
                .showImageOnLoading(R.drawable.default_album_cover)
                .showImageForEmptyUri(R.drawable.default_album_cover)
                .showImageOnFail(R.drawable.default_album_cover)
                .cacheInMemory(true)
                .cacheOnDisk(true)
                .displayer(new RoundedBitmapDisplayer(6))
                .considerExifParams(true)
                .bitmapConfig(Bitmap.Config.RGB_565)
                .build();
    }

    @Override
    public int getCount() {
        return albums.size();
    }

    @Override
    public Object getItem(int position) {
        return albums.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        SimpleAlbumModel album = albums.get(position);
        final ViewHolder holder;
        View view = convertView;
        if (view == null) {
            view = inflater.inflate(R.layout.item_album_simple_grid, parent, false);
            holder = new ViewHolder();
            holder.imageView = (ImageView) view.findViewById(R.id.itemImage);
            holder.titleTextView = (TextView) view.findViewById(R.id.itemText);
            view.setTag(holder);
        } else {
            holder = (ViewHolder) view.getTag();
        }

        ImageLoader.getInstance().displayImage(album.getAlbum_picture(),
                holder.imageView, options);
        holder.titleTextView.setText(album.getAlbum_name());
        view.setOnClickListener(new ItemClickListener(album));
        return view;
    }

    static class ViewHolder {
        ImageView imageView;
        TextView titleTextView;
    }

    class ItemClickListener implements View.OnClickListener {
       SimpleAlbumModel simpleAlbumModel;

        public ItemClickListener(SimpleAlbumModel simpleAlbumModel) {
            this.simpleAlbumModel = simpleAlbumModel;
        }

        @Override
        public void onClick(View v) {
            String url= QTUrl.video_album_list+simpleAlbumModel.getId();
            Intent intent = new Intent(context, VideoGridActivity_.class);
            intent.putExtra("title", simpleAlbumModel.getAlbum_name());
            intent.putExtra("url", url);
            context.startActivity(intent);
        }
    }
}