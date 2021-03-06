<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * @Route("products",name="product.index")
     * @return Response
     *
     */
    public function index(): Response
    {
        $products = $this->repository->findAll();
        dump($products);
        return $this->render('product/index.html.twig', [
            'current_menu' => 'products',
            'products' => $products
        ]);
    }

    /**
     * @Route("/products/{slug}-{id}", name="product.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Product $product
     * @param string $slug
     * @return Response
     */
    public function show(Product $product, string $slug): Response
    {
        if ($product->getSlug() !== $slug) {
            return $this->redirectToRoute('product.show', [
                'id' => $product->getId(),
                'slug' => $product->getSlug()
            ], 301);
        }
        $product = $this->repository->find($product->getId());
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'current_menu' => 'products'
        ]);
    }


    /**
     * @Route("/product/ascendant",name="product.ascendant")
     * @return Response
     *
     */
    public function ascendant(): Response
    {
        $products = $this->repository->findAllByPriceAsc();
        dump($products);
        return $this->render('product/ascendant.html.twig', [
            'current_menu' => 'ascendant',
            'products' => $products
        ]);
    }

}
