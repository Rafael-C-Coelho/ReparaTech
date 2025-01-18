package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters;

import static java.security.AccessController.getContext;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Order;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.OrderDisplay;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;

public class OrderListAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Product> products;
    private ArrayList<OrderDisplay> orders;

    public OrderListAdapter(Context context, ArrayList<OrderDisplay> orders) {
        this.context = context;
        this.orders = orders;
        this.inflater = LayoutInflater.from(context);
    }

    @Override
    public int getCount() {
        return orders != null ? orders.size() : products.size();
    }

    @Override
    public Object getItem(int position) {
        return orders != null ? orders.get(position) : products.get(position);
    }

    @Override
    public long getItemId(int position) {
        return orders != null ? orders.get(position).getId() : products.get(position).getId();
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        OrderDisplay order = orders.get(position);

        if (convertView == null) {
            convertView = LayoutInflater.from(context).inflate(R.layout.item_list_order, parent, false);
        }

        TextView tvId = convertView.findViewById(R.id.tvId);
        TextView tvStatus = convertView.findViewById(R.id.tvStatus);
        TextView tvTotalOrder = convertView.findViewById(R.id.tvTotalOrder);
        TextView tvProducts = convertView.findViewById(R.id.tvProducts);
        TextView tvProductQuantity = convertView.findViewById(R.id.tvProductQuantity);

        tvId.setText(String.valueOf(order.getId()));
        tvStatus.setText(order.getStatus());
        tvTotalOrder.setText(String.valueOf(order.getTotalOrder()));
        tvProducts.setText(order.getProductNames());
        tvProductQuantity.setText(String.valueOf(order.getTotalQuantity()));

        return convertView;
    }

    private class ViewHolderOrder {
        private TextView tvId;
        private TextView tvStatus;
        private TextView tvTotalOrder;
        private TextView tvProducts;
        private TextView tvProductQuantity;

        public ViewHolderOrder(View view) {
            tvId = view.findViewById(R.id.tvId);
            tvStatus = view.findViewById(R.id.tvStatus);
            tvTotalOrder = view.findViewById(R.id.tvTotalOrder);
            tvProducts = view.findViewById(R.id.tvProducts);
            tvProductQuantity = view.findViewById(R.id.tvProductQuantity);
        }

        public void update(Order order) {
            tvId.setText(String.valueOf(order.getId()));
            tvStatus.setText(order.getStatus());
            tvTotalOrder.setText(String.valueOf(order.getTotalOrder()));
            tvProductQuantity.setText(String.valueOf(order.getProductQuantity()));

            StringBuilder productsInfo = new StringBuilder();
            for (Product product : order.getProducts()) {
                productsInfo.append(product.getName()).append("\n");
            }
            tvProducts.setText(productsInfo.toString().trim());
        }
    }
}
