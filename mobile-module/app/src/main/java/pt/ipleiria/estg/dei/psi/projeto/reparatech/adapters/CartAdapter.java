package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage.ProductsListAdapter;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.listeners.CartItemChangeListener;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.CartItem;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechDBHelper;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;

public class CartAdapter extends BaseAdapter {
    private final Context context;
    private final ArrayList<CartItem> cartItems;
    private LayoutInflater inflater;
    private final CartItemChangeListener listener;

    public CartAdapter(Context context, ArrayList<CartItem> cartItems, CartItemChangeListener listener) {
        this.context = context;
        this.cartItems = cartItems;
        this.listener = listener;
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
        if (inflater == null) {
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if (convertView == null) {
            convertView = inflater.inflate(R.layout.item_cart, null);
        }

        ViewHolderList viewHolderList = (ViewHolderList) convertView.getTag();
        if (viewHolderList == null) {
            viewHolderList = new ViewHolderList(convertView);
            convertView.setTag(viewHolderList);
        }
        viewHolderList.update(cartItems.get(i));

        return convertView;
    }

    public void updateItem(int position, CartItem updatedItem) {
        if (position >= 0 && position < cartItems.size()) {
            cartItems.set(position, updatedItem);
            notifyDataSetChanged();
        }
    }

    private class ViewHolderList {
        private final TextView tvProductName, tvProductPrice, tvProductId, tvQuantity, tvId;
        private final ImageView ivProductImage;
        private final Button btnMinus, btnPlus;

        public ViewHolderList(View view) {
            tvId = view.findViewById(R.id.tvId);
            tvProductId = view.findViewById(R.id.tvProductId);
            tvProductName = view.findViewById(R.id.tvProductName);
            tvProductPrice = view.findViewById(R.id.tvProductPrice);
            tvQuantity = view.findViewById(R.id.tvQuantity);
            ivProductImage = view.findViewById(R.id.ivProductImage);
            btnMinus = view.findViewById(R.id.btnMinus);
            btnPlus = view.findViewById(R.id.btnPlus);

            btnMinus.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    int id = Integer.parseInt(tvId.getText().toString());
                    int quantity = Integer.parseInt(tvQuantity.getText().toString());
                    Product product = ReparaTechSingleton.getInstance(context).getProductFromDB(id);
                    if (quantity > 1) {
                        quantity--;
                        tvQuantity.setText(String.valueOf(quantity));
                        ReparaTechSingleton.getInstance(context).updateCartItem(id, quantity);
                        tvProductPrice.setText(product.getPrice() * quantity + "€");
                        notifyDataSetChanged();
                    } else if (quantity == 1) {
                        ReparaTechSingleton.getInstance(context).removeCartItem(id);
                        cartItems.clear();
                        cartItems.addAll(ReparaTechSingleton.getInstance(context).getDbHelper().getAllCartItemsDB());
                        notifyDataSetChanged();
                    }
                    updateItem(getPositionById(id), new CartItem(id, Integer.parseInt(tvProductId.getText().toString()), quantity));

                    if (listener != null) {
                        listener.onCartItemChanged();
                    }
                }
            });

            btnPlus.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    int id = Integer.parseInt(tvId.getText().toString());
                    int quantity = Integer.parseInt(tvQuantity.getText().toString());
                    quantity++;
                    Product product = ReparaTechSingleton.getInstance(context).getProductFromDB(Integer.parseInt(tvProductId.getText().toString()));
                    if (product.getStock() < quantity) {
                        return;
                    }
                    tvQuantity.setText(String.valueOf(quantity));
                    ReparaTechSingleton.getInstance(context).updateCartItem(id, quantity);
                    notifyDataSetChanged();
                    updateItem(getPositionById(id), new CartItem(id, Integer.parseInt(tvProductId.getText().toString()), quantity));

                    if (listener != null) {
                        listener.onCartItemChanged();
                    }
                }
            });

        }

        private int getPositionById(int id) {
            for (int i = 0; i < cartItems.size(); i++) {
                if (cartItems.get(i).getId() == id) {
                    return i;
                }
            }
            return -1;
        }

        public void update(CartItem cartItem) {
            Product product = ReparaTechSingleton.getInstance(context).getProductFromDB(cartItem.getIdProduct());
            tvId.setText(String.valueOf(cartItem.getId()));
            tvProductId.setText(String.valueOf(cartItem.getIdProduct()));
            tvProductName.setText(product.getName());
            tvProductPrice.setText(product.getPrice() * cartItem.getQuantity() + "€");
            tvQuantity.setText(String.valueOf(cartItem.getQuantity()));
            Glide.with(context)
                    .load(product.getImage())
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(ivProductImage);
        }
    }
}
