package com.zhanglubao.lol.model;

/**
 * Created by rocks on 15-5-31.
 */
public class SimpleAlbumModel {
    String id;
    String album_name;
    String album_picture;

    public String getAlbum_picture() {
        return album_picture;
    }

    public void setAlbum_picture(String album_picture) {
        this.album_picture = album_picture;
    }

    public String getAlbum_name() {
        return album_name;
    }

    public void setAlbum_name(String album_name) {
        this.album_name = album_name;
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }
}
