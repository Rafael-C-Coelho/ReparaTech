package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.ProductsListAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.CartItem;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechDBHelper;

public class CartAdapter extends BaseAdapter {
    private final Context context;
    private final ArrayList<CartItem> cartItems;
    private LayoutInflater inflater;

    public CartAdapter(Context context, ArrayList<CartItem> cartItems) {
        this.context = context;
        this.cartItems = cartItems;
    }

    @Override
    public int getCount() {
        return cartItems.size();
    }

    @Override
    public Object getItem(int i) {
        return cartItems.get(i);
    }

    @Override
    public long getItemId(int i) {
        return cartItems.get(i).getId();
    }

    @Override
    public View getView(int i, View convertView, ViewGroup parent) {
        if(inflater == null){
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if(convertView == null){
            convertView = inflater.inflate(R.layout.item_cart, null);
        }

        ViewHolderList viewHolderList = (ViewHolderList) convertView.getTag();
        if(viewHolderList == null){
            viewHolderList = new ViewHolderList(convertView);
            convertView.setTag(viewHolderList);
        }

        return convertView;

    }

    private class ViewHolderList {
        private final TextView tvProductName, tvProductPrice, tvQuantity;
        private final ImageView ivProductImage;
        public ViewHolderList(View view) {
            tvProductName = view.findViewById(R.id.tvProductName);
            tvProductPrice = view.findViewById(R.id.tvProductPrice);
            tvQuantity = view.findViewById(R.id.tvQuantity);
            ivProductImage = view.findViewById(R.id.ivProductImage);
        }

        public void update(CartItem cartItem) {
            ReparaTechDBHelper dbHelper = new ReparaTechDBHelper(context);
            Product product = dbHelper.getAllProductsDB().get(cartItem.getIdProduct());
            tvProductName.setText(product.getName());
            tvProductPrice.setText(product.getPrice() * cartItem.getQuantity() + " €");
            tvQuantity.setText(cartItem.getQuantity() + "");
            Glide.with(context)
                    .load(product.getImage())
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(ivProductImage);
        }
    }
}
