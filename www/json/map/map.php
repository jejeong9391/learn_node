<?php

?>


	<style>html,body{margin:0;}</style>

	<div id="map" style="width:100%;height:100%;"></div>
	<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=de51be8451f7de15afa56471753ebc32"></script>
	<script>
	var container = document.getElementById('map');
    		var options = {
    			center: new daum.maps.LatLng(33.450701, 126.570667),
    			level: 3,
    			disableDoubleClickZoom: true,
    			disableDoubleClick: true,
    			scrollwheel: false,
    			draggable: false
    		};

    		var map = new daum.maps.Map(container, options);

    		// 마커를 표시할 위치와 title 객체 배열입니다
            var positions = [
                {
                    title: '카카오',
                    latlng: new daum.maps.LatLng(33.450705, 126.570677)
                }
            ];

            // 마커 이미지의 이미지 주소입니다
            var imageSrc = "http://t1.daumcdn.net/localimg/localimages/07/mapapidoc/markerStar.png";

            for (var i = 0; i < positions.length; i ++) {

                // 마커 이미지의 이미지 크기 입니다
                var imageSize = new daum.maps.Size(24, 35);

                // 마커 이미지를 생성합니다
                var markerImage = new daum.maps.MarkerImage(imageSrc, imageSize);

                // 마커를 생성합니다
                var marker = new daum.maps.Marker({
                    map: map, // 마커를 표시할 지도
                    position: positions[i].latlng, // 마커를 표시할 위치
                    title : positions[i].title, // 마커의 타이틀, 마커에 마우스를 올리면 타이틀이 표시됩니다
                    image : markerImage // 마커 이미지
                });
            }
	</script>
