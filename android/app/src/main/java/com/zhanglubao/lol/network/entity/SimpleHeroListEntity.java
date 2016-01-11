package com.zhanglubao.lol.network.entity;

import com.zhanglubao.lol.model.SimpleHeroModel;

import java.util.List;

/**
 * Created by rocks on 15-6-1.
 */
public class SimpleHeroListEntity {
    List<SimpleHeroModel> heros;
    int status;

    public List<SimpleHeroModel> getHeros() {
        return heros;
    }

    public void setHeros(List<SimpleHeroModel> heros) {
        this.heros = heros;
    }

    public int getStatus() {
        return status;
    }

    public void setStatus(int status) {
        this.status = status;
    }
}
