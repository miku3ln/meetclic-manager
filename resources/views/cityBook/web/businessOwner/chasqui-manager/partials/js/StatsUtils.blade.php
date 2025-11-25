<script>
    const StatsUtils = {
        compute(root) {
            if (!root) return null;
            const box = new THREE.Box3().setFromObject(root);
            const size = new THREE.Vector3();
            box.getSize(size);
            let meshes = 0, tris = 0;
            root.traverse(o => {
                if (o.isMesh && o.geometry) {
                    meshes++;
                    const g = o.geometry;
                    const t = g.index ? (g.index.count / 3) :
                        (g.attributes?.position ? g.attributes.position.count / 3 : 0);
                    tris += Math.floor(t);
                }
            });
            return {
                meshes,
                triangles: tris,
                bbox: {x: +size.x.toFixed(4), y: +size.y.toFixed(4), z: +size.z.toFixed(4)}
            };
        }
    };

</script>
