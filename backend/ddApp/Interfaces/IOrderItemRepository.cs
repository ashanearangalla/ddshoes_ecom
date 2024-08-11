using ddApp.Models;
using ddApp.Models;
using System.Collections.Generic;

namespace ddApp.Interfaces
{
    public interface IOrderItemRepository
    {
        ICollection<OrderItem> GetOrderItems();
        OrderItem GetOrderItem(int id);
        bool OrderItemExists(int id);
        bool CreateOrderItem(OrderItem orderItem);
        bool UpdateOrderItem(OrderItem orderItem);
        bool DeleteOrderItem(OrderItem orderItem);
        bool Save();
    }
}
