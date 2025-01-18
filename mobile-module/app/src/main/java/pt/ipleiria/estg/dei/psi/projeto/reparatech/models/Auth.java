package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

import java.nio.charset.StandardCharsets;
import java.util.ArrayList;
import java.util.Collections;
import java.util.List;
import java.util.Map;

import com.fasterxml.jackson.databind.ObjectMapper;
import android.util.Base64;

public class Auth {
    private String email;
    private String token;
    private String refreshToken;

    public Auth() {
    }

    public Auth(String email, String token, String refreshToken) {
        this.email = email;
        this.token = token;
        this.refreshToken = refreshToken;
    }

    public String getRole() {
        try {
            // Split the token into parts (header, payload, signature)
            String[] tokenParts = token.split("\\.");
            if (tokenParts.length < 2) {
                throw new IllegalArgumentException("Invalid JWT token format");
            }

            // Decode the payload (Base64 URL encoded)
            String payload = new String(Base64.decode(tokenParts[1], Base64.URL_SAFE), StandardCharsets.UTF_8);

            // Parse the payload JSON
            ObjectMapper objectMapper = new ObjectMapper();
            Map<String, Object> claims = objectMapper.readValue(payload, Map.class);

            // Extract roles
            Object rolesObject = claims.get("roles");
            if (rolesObject instanceof List) {
                ArrayList<?> roles = (ArrayList<?>) rolesObject;
                if (!roles.isEmpty() && roles.get(0) instanceof String) {
                    return (String) roles.get(0); // Return the first role
                }
            }

        } catch (Exception e) {
            System.err.println("Error decoding JWT token: " + e.getMessage());
        }

        return null; // Return null if roles are not found or decoding fails
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = this.email;
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
