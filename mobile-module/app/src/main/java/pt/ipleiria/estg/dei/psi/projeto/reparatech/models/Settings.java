package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

import android.content.SharedPreferences;

public class Settings {
    private String url;
    private SharedPreferences sharedPreferences;

    public Settings(SharedPreferences sharedPreferences) {
        this.sharedPreferences = sharedPreferences;
        this.url = sharedPreferences.getString("server_url", null);
    }

    public String getUrl() {
        return url;
    }

    public void setUrl(String url) {
        this.url = url;
        sharedPreferences.edit().putString("server_url", url).apply();
    }
}
