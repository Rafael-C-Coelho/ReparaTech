package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

public class Auth {
    private String username;
    private String token;
    private String refreshToken;

    public Auth() {
    }

    public Auth(String username, String token, String refreshToken) {
        this.username = username;
        this.token = token;
        this.refreshToken = refreshToken;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getToken() {
        return token;
    }

    public void setToken(String token) {
        this.token = token;
    }

    public String getRefreshToken() {
        return refreshToken;
    }

    public void setRefreshToken(String refreshToken) {
        this.refreshToken = refreshToken;
    }
}
