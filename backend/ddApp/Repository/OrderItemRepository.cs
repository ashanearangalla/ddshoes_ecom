
using ddApp.Interfaces;
using ddApp.Models;
using ddApp.DAL;
using ddApp.Interfaces;
using ddApp.Models;
using System.Collections.Generic;
using System.Linq;


namespace ddApp.Repository
{
    public class OrderItemRepository : IOrderItemRepository
    {
        private readonly DataContext _context;

        public OrderItemRepository(DataContext context)
        {
            _context = context;
        }

        public ICollection<OrderItem> GetOrderItems()
        {
            return _context.OrderItems.ToList();
        }

        public OrderItem GetOrderItem(int id)
        {
            return _context.OrderItems.Find(id);
        }

        public bool OrderItemExists(int id)
        {
            return _context.OrderItems.Any(oi => oi.OrderItemID == id);
        }

        public bool CreateOrderItem(OrderItem orderItem)
        {
            _context.OrderItems.Add(orderItem);
            return Save();
        }

        public bool UpdateOrderItem(OrderItem orderItem)
        {
            _context.OrderItems.Update(orderItem);
            return Save();
        }

        public bool DeleteOrderItem(OrderItem orderItem)
        {
            _context.OrderItems.Remove(orderItem);
            return Save();
        }

        public bool Save()
        {
            return _context.SaveChanges() > 0;
        }
    }
}