namespace ddApp.DAL
{
    using ddApp.Models;
    using Microsoft.EntityFrameworkCore;

    public class DataContext : DbContext
    {
        public DataContext(DbContextOptions<DataContext> options) : base(options)
        {
        }

        public DbSet<Product> Products { get; set; }
        public DbSet<Order> Orders { get; set; }
        public DbSet<OrderItem> OrderItems { get; set; }
        public DbSet<Customer> Customers { get; set; }
        public DbSet<MainStock> MainStocks { get; set; }
        public DbSet<SubStock> SubStocks { get; set; }
        public DbSet<Outlet> Outlets { get; set; }
        public DbSet<Partner> Partners { get; set; }
        public DbSet<PreOrder> PreOrders { get; set; }
        public DbSet<Sale> Sales { get; set; }
        public DbSet<User> Users { get; set; }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            // Order - Customer relationship
            modelBuilder.Entity<Order>()
                .HasOne(o => o.Customer)
                .WithMany(c => c.Orders)
                .HasForeignKey(o => o.CustomerID);

            // Order - User relationship
            modelBuilder.Entity<Order>()
                .HasOne(o => o.User)
                .WithMany(u => u.Orders)
                .HasForeignKey(o => o.UserID);

            // OrderItem composite key
            modelBuilder.Entity<OrderItem>()
                .HasKey(oi => oi.OrderItemID);

            // OrderItem - Order relationship
            modelBuilder.Entity<OrderItem>()
                .HasOne(oi => oi.Order)
                .WithMany(o => o.OrderItems)
                .HasForeignKey(oi => oi.OrderID);

            // OrderItem - Product relationship
            modelBuilder.Entity<OrderItem>()
                .HasOne(oi => oi.Product)
                .WithMany(p => p.OrderItems)
                .HasForeignKey(oi => oi.ProductID);

            // SubStock - Product relationship
            modelBuilder.Entity<SubStock>()
                .HasOne(ss => ss.Product)
                .WithMany(p => p.SubStocks)
                .HasForeignKey(ss => ss.ProductID);

            // SubStock - User relationship
            modelBuilder.Entity<SubStock>()
                .HasOne(ss => ss.User)
                .WithMany(u => u.SubStocks)
                .HasForeignKey(ss => ss.UserID);

            // PreOrder - Product relationship
            modelBuilder.Entity<PreOrder>()
                .HasOne(po => po.Product)
                .WithMany(p => p.PreOrders)
                .HasForeignKey(po => po.ProductID);

            // PreOrder - Customer relationship
            modelBuilder.Entity<PreOrder>()
                .HasOne(po => po.Customer)
                .WithMany(c => c.PreOrders)
                .HasForeignKey(po => po.CustomerID);

            // Sale - SubStock relationship
            modelBuilder.Entity<Sale>()
                .HasOne(s => s.SubStock)
                .WithMany(ss => ss.Sales)
                .HasForeignKey(s => s.SubStockID);

            // Outlet - User relationship
            modelBuilder.Entity<Outlet>()
                .HasOne(o => o.User)
                .WithOne(u => u.Outlet)
                .HasForeignKey<Outlet>(o => o.UserID);

            // Partner - User relationship
            modelBuilder.Entity<Partner>()
                .HasOne(p => p.User)
                .WithOne(u => u.Partner)
                .HasForeignKey<Partner>(p => p.UserID);

            // Configure decimal properties
            modelBuilder.Entity<Product>()
                .Property(p => p.Price)
                .HasPrecision(18, 2);

            modelBuilder.Entity<OrderItem>()
                .Property(oi => oi.Quantity)
                .HasPrecision(18, 2);

            modelBuilder.Entity<PreOrder>()
                .Property(po => po.Quantity)
                .HasPrecision(18, 2);
        }
    }
}
