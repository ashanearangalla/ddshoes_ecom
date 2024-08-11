using ddApp.DAL;
using ddApp.Interfaces;
using ddApp.Models;

namespace ddApp.Repository
{
    public class SubStockRepository : ISubStockRepository
    {
        private readonly DataContext _context;

        public SubStockRepository(DataContext context)
        {
            _context = context;
        }

        public ICollection<SubStock> GetSubStocks()
        {
            return _context.SubStocks.ToList();
        }

        public SubStock GetSubStock(int id)
        {
            return _context.SubStocks.Find(id);
        }

        public bool SubStockExists(int id)
        {
            return _context.SubStocks.Any(ss => ss.SubStockID == id);
        }

        public bool CreateSubStock(SubStock subStock)
        {
            _context.SubStocks.Add(subStock);
            return Save();
        }

        public bool UpdateSubStock(SubStock subStock)
        {
            _context.SubStocks.Update(subStock);
            return Save();
        }

        public bool DeleteSubStock(SubStock subStock)
        {
            _context.SubStocks.Remove(subStock);
            return Save();
        }

        public bool Save()
        {
            return _context.SaveChanges() > 0;
        }
        public ICollection<SubStock> GetSubStocksByUserId(int userId)
        {
            return _context.SubStocks.Where(s => s.UserID == userId).ToList();
        }
    }
}
