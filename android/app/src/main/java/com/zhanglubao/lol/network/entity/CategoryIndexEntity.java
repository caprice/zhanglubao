package com.zhanglubao.lol.network.entity;

import com.zhanglubao.lol.model.SimpleAlbumModel;
import com.zhanglubao.lol.model.SimpleHeroModel;
import com.zhanglubao.lol.model.SimpleUserModel;

import java.util.List;

/**
 * Created by rocks on 15-6-1.
 */
public class CategoryIndexEntity {

    List<SimpleHeroModel> heros;
    List<SimpleAlbumModel>albums;
    List<SimpleUserModel> comms;
    List<SimpleUserModel>teams;
    List<SimpleUserModel>matches;
    List<SimpleUserModel>pros;
    List<SimpleUserModel>masters;

    public List<SimpleAlbumModel> getAlbums() {
        return albums;
    }

    public void setAlbums(List<SimpleAlbumModel> albums) {
        this.albums = albums;
    }

    public List<SimpleHeroModel> getHeros() {
        return heros;
    }

    public void setHeros(List<SimpleHeroModel> heros) {
        this.heros = heros;
    }

    public List<SimpleUserModel> getMasters() {
        return masters;
    }

    public void setMasters(List<SimpleUserModel> masters) {
        this.masters = masters;
    }

    public List<SimpleUserModel> getMatches() {
        return matches;
    }

    public void setMatches(List<SimpleUserModel> matches) {
        this.matches = matches;
    }

    public List<SimpleUserModel> getPros() {
        return pros;
    }

    public void setPros(List<SimpleUserModel> pros) {
        this.pros = pros;
    }

    public List<SimpleUserModel> getTeams() {
        return teams;
    }

    public void setTeams(List<SimpleUserModel> teams) {
        this.teams = teams;
    }

    public List<SimpleUserModel> getComms() {
        return comms;
    }

    public void setComms(List<SimpleUserModel> comms) {
        this.comms = comms;
    }
}
