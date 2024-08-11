using AutoMapper;
using ddApp.Dto;
using ddApp.Interfaces;
using ddApp.Models;
using Microsoft.AspNetCore.Mvc;
using System.Collections.Generic;
using System.Linq;

namespace ddApp.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class SaleController : ControllerBase
    {
        private readonly ISaleRepository _saleRepository;
        private readonly IMapper _mapper;

        public SaleController(ISaleRepository saleRepository, IMapper mapper)
        {
            _saleRepository = saleRepository;
            _mapper = mapper;
        }

        [HttpGet]
        [ProducesResponseType(200, Type = typeof(IEnumerable<SaleDto>))]
        public IActionResult GetSales()
        {
            var sales = _mapper.Map<List<SaleDto>>(_saleRepository.GetSales());

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(sales);
        }

        [HttpGet("{saleId}")]
        [ProducesResponseType(200, Type = typeof(SaleDto))]
        [ProducesResponseType(400)]
        public IActionResult GetSale(int saleId)
        {
            if (!_saleRepository.SaleExists(saleId))
                return NotFound();

            var sale = _mapper.Map<SaleDto>(_saleRepository.GetSale(saleId));

            if (!ModelState.IsValid)
            {
                return BadRequest(ModelState);
            }

            return Ok(sale);
        }

        [HttpPost]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult CreateSale([FromBody] SaleDto saleCreate)
        {
            if (saleCreate == null)
                return BadRequest(ModelState);

            var sale = _saleRepository.GetSales()
                .Where(s => s.SaleID == saleCreate.SaleID)
                .FirstOrDefault();

            if (sale != null)
            {
                ModelState.AddModelError("", "Sale already exists");
                return StatusCode(422, ModelState);
            }

            var saleMap = _mapper.Map<Sale>(saleCreate);

            if (!_saleRepository.CreateSale(saleMap))
            {
                ModelState.AddModelError("", "Something went wrong while saving");
                return StatusCode(500, ModelState);
            }

            return Ok("Successfully created");
        }

        [HttpPut("{saleId}")]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult UpdateSale(int saleId, [FromBody] SaleDto updatedSale)
        {
            if (updatedSale == null || saleId != updatedSale.SaleID)
                return BadRequest(ModelState);

            if (!_saleRepository.SaleExists(saleId))
                return NotFound();

            var saleMap = _mapper.Map<Sale>(updatedSale);

            if (!_saleRepository.UpdateSale(saleMap))
            {
                ModelState.AddModelError("", "Something went wrong while updating");
                return StatusCode(500, ModelState);
            }

            return NoContent();
        }

        [HttpDelete("{saleId}")]
        [ProducesResponseType(204)]
        [ProducesResponseType(400)]
        public IActionResult DeleteSale(int saleId)
        {
            if (!_saleRepository.SaleExists(saleId))
                return NotFound();

            var sale = _saleRepository.GetSale(saleId);

            if (!_saleRepository.DeleteSale(sale))
            {
                ModelState.AddModelError("", "Something went wrong while deleting");
                return StatusCode(500, ModelState);
            }

            return NoContent();
        }
    }
}
